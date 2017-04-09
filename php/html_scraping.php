<?php
//Class subject to be renamed
//Written by Conrad Weiser
require __DIR__ . '/vendor/autoload.php';

use League\Csv\Reader;
use Sunra\PhpSimple\HtmlDomParser;

$test = new RetrieveExternalData;
$test->getDataFromGoogle("MOMO");


class RetrieveExternalData {

	private function getJsonFromYql($url) {


		$c = curl_init();
   		curl_setopt($c, CURLOPT_URL, $url);
   		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
   		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
   		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
   		$json = curl_exec($c);
   		curl_close($c);

   		return $json;

	}

	/** Method which gets the required information from MorningStar and returns it in an array given the following data
	 * [0] = Previous year Interest Expense
	 * [1] = Previous year EBITDA
	 * [2] = Current Year Assets
	 * [3] = Previous Year Assets
	 * [4] = Current Year Liabilities
	 * [5] = Previous Year Liabilities
	 * [6] = P/S Value
	 * [7] = P/B Value
	 * [8] = P/E Value
	 **/
	public function getMorningstarInformation($stock_identifier) {

		$response = [];

		//WARNING! MASSIVE BUG! THE FOLLOWING CSV PARSING DOES NOT WORK WITH ALL COMPANIES! DO VALIDATION CHECKING!!!!!!

		/* ------------------------- Don't remember what this is ------------------- */
	
		//Form the URL with the stock ticker to pull the financial data from
		$financialUrl = 'http://financials.morningstar.com/ajax/ReportProcess4CSV.html?t='
			. $stock_identifier . '&reportType=is&period=12&dataType=A&order=asc&columnYear=5&number=3';
		
		//Get the file contents and write it to a tempfile
		$source = file_get_contents($financialUrl);
		$temp = tmpfile();
		fwrite($temp, $source);
		$metaData = stream_get_meta_data($temp);
		$tmpFilename = $metaData['uri'];
	
		$csv = Reader::createFromPath($tmpFilename);
		$results = $csv->fetch();
		//From the above CSV reader, we need the Interest Expense and EBITDA for the previous year
		
		foreach($results as $row) {

			if($row[0] == "Interest Expense") {

				array_push($response, $row[count($row) - 1]);
			}

			else if($row[0] == "EBITDA") {

				array_push($response, $row[count($row) - 1]);
			}
		}

	
		fclose($temp);
	
		/* -------------------------- BALANCE SHEET ----------------------------- */
	
		//Pull in the balance sheet page to get the remainder of the data
		$balanceSheetUrl = 'http://financials.morningstar.com/ajax/ReportProcess4CSV.html?t='
			. $stock_identifier . '&reportType=bs&period=12&dataType=A&order=asc&columnYear=5&number=3';
	
		//Get the file contents and write it to another tempfile
		$source = file_get_contents($balanceSheetUrl);
		$temp = tmpfile();
		fwrite($temp, $source);
		$metaData = stream_get_meta_data($temp);
		$tmpFilename = $metaData['uri'];
	
		$csv = Reader::createFromPath($tmpFilename);
	
		//Get the last two values of the Current Assets and Current Liabilities row
		$results = $csv->fetch();

		foreach($results as $row) {

			if($row[0] == "Total current assets") {

				$totalCurrentAssets = [];
				array_push($totalCurrentAssets, $row[count($row) - 1], $row[count($row) - 2]);

				array_push($response, $totalCurrentAssets);

			}

			else if($row[0] == "Current liabilities") {

				$totalCurrentLiabilities = [];
				array_push($totalCurrentLiabilities, $row[count($row) - 1], $row[count($row) - 2]);

				array_push($response, $totalCurrentLiabilities);
			}
		}

		fclose($temp);
	
		/* ----------------------------- INDUSTRY AVERAGES ------------------------------*/

		//Sadly we have to parse this normally.
		$industryPeersUrl = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url%3D%22http%3A%2F%2Ffinancials.morningstar.com%2Fcmpind%2Fcompetitors%2Findustry-peer-data.action%3Ftype%3Dcom%26t%3D' . $stock_identifier . '%26region%3Dusa%26culture%3Den-US%26cur%3D%22%20and%20compat%3D%22html5%22%20and%20xpath%3D' . "'%2F%2Ftable%5Bcontains(%40class%2C%22r_table1%20r_txt2%22)%5D'&format=json&diagnostics=true&callback=";

		$json = json_decode($this->getJsonFromYql($industryPeersUrl), true);
		$json = $json["query"]["results"]["table"]["tbody"]["tr"];

		//For some reason, we get a crapton of whitespace in these responses. Remove it.
		$psValue = preg_replace('/\s+/', '', $json["53"]["td"]["3"]["content"]);
		$pbValue = preg_replace('/\s+/', '', $json["53"]["td"]["4"]["content"]);
		$peValue = preg_replace('/\s+/', '', $json["53"]["td"]["5"]["content"]);

		array_push($response, $psValue, $pbValue, $peValue);	

		print_r($response);	

		return $response;
	}


	/**
	 * Gets information from Google Finances, returns the following information..
	 * [0] - BetaValue for the ticker
	 * [1] - Current stock price
	 * [2] - Revenue Value 
	 * [3] - Cost of Revenue
	 * [4] - Operating Income
	 * [5] - Net Income
	 * [6] - Dividends Per Share
	 * [7] - Dilluted Nomralized EPS
	 * [8] - Minotiry Interest (can be just a dash)
	 * [9] - Cash and Short Term Investments
	 * [10] - Total Current Assets
	 * [11] - Total Assets
	 * [12] - Total Current Liabilities
	 * [13] - Total Long Term Debt
	 * [14] - Total Liabilities
	 * [15] - Total Equity
	 * [16] - Total Common Shares Outstanding
	 * [17] - Preferred Stock Non Redeemable Net
	 * [18] - Deprecation Depletion
	 * [19] - Capital Expenditures
	 * [20] - Cash From Operating Activities
	 */
	public function getDataFromGoogle($stock_identifier) {

		$response = [];

		//YQL URL for summary
		$url = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url%3D%22https%3A%2F%2Fwww.google.com%2Ffinance%3Fq%3D' . $stock_identifier . '%22%20and%20compat%3D%22html5%22%20and%20xpath%3D' . "'%2F%2Fdiv%5Bcontains(%40class%2C%22id-market-data-div%22)%5D'" . '&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=';

		$json = json_decode($this->getJsonFromYql($url), true);

		$betaValue = $json["query"]["results"]["div"]["div"]["1"]["div"]["0"]["table"]["1"]["tbody"]["tr"]["3"]["td"]["1"]["content"];
		$currentPrice = $json["query"]["results"]["div"]["div"]["0"]["div"]["0"]["span"]["span"]["content"];

		array_push($response, $betaValue, $currentPrice);

		/* -------------------------------------- Financials --> Income Statement/Balance Sheet/Cash Flow ---------------------*/

		$url = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url%3D%22https%3A%2F%2Fwww.google.com%2Ffinance%3Fq%3D' . $stock_identifier . '%26fstype%3Dii%26ei%3DCFrdWImFNdiGe_atlegC%22%20and%20compat%3D%22html5%22%20and%20xpath%3D' . "'%2F%2Ftable%5Bcontains(%40class%2C%22gf-table%20rgt%22)%5D'" . '&format=json&diagnostics=true&callback=';

		$json = json_decode($this->getJsonFromYql($url), true);
		$json = $json["query"]["results"]["table"];

		//If the value is red, that means there is an additional span class which needs to be checked through. 

		$revanueValue = empty($json["1"]["tbody"]["tr"]["0"]["td"]["1"]["content"]) ? $json["1"]["tbody"]["tr"]["0"]["td"]["1"]["span"]["content"] : $json["1"]["tbody"]["tr"]["0"]["td"]["1"]["content"];
		$costOfRevanue = $json["1"]["tbody"]["tr"]["3"]["td"]["1"]["content"];
		$operatingIncome = empty($json["1"]["tbody"]["tr"]["12"]["td"]["1"]["content"]) ? $json["1"]["tbody"]["tr"]["12"]["td"]["1"]["span"]["content"] : $json["1"]["tbody"]["tr"]["12"]["td"]["1"]["content"];
		$netIncome = empty($json["1"]["tbody"]["tr"]["24"]["td"]["1"]["content"]) ? $json["1"]["tbody"]["tr"]["24"]["td"]["1"]["span"]["content"] : $json["0"]["tbody"]["tr"]["24"]["td"]["1"]["content"];
		$dividendsPerShare = $json["1"]["tbody"]["tr"]["35"]["td"]["1"]["content"];
		$dilutedNormalizedEps = empty($json["1"]["tbody"]["tr"]["48"]["td"]["1"]["content"]) ? $json["1"]["tbody"]["tr"]["48"]["td"]["1"]["span"]["content"] : $json["1"]["tbody"]["tr"]["48"]["td"]["1"]["content"];
		$minorityInterest = $json["1"]["tbody"]["tr"]["18"]["td"]["1"]["content"];

		//NOTE: THE FOLLOWING DATA IS !NOT! ANUAL, NO CHANGE HAS BEEN SEEN BETWEEN QUARTERLY AND ANNUAL FOR THE 53 WEEKS HOWEVER
		$cashAndShortTermInvestments = $json["2"]["tbody"]["tr"]["2"]["td"]["1"]["content"];
		$totalCurrentAssets = $json["2"]["tbody"]["tr"]["9"]["td"]["1"]["content"];
		$totalAssets = $json["2"]["tbody"]["tr"]["16"]["td"]["1"]["content"];
		$totalCurrentLiabilities = $json["2"]["tbody"]["tr"]["22"]["td"]["1"]["content"];
		$totalLongTermDebt = $json["2"]["tbody"]["tr"]["25"]["td"]["1"]["content"];
		$totalLiabilities = $json["2"]["tbody"]["tr"]["30"]["td"]["1"]["content"];
		$totalEquity = $json["2"]["tbody"]["tr"]["38"]["td"]["1"]["content"];
		$totalCommonSharesOutstanding = $json["2"]["tbody"]["tr"]["41"]["td"]["1"]["content"];
		$preferredStockNonRedeemableNet = $json["2"]["tbody"]["tr"]["32"]["td"]["1"]["content"];

		$deprecationDepletion = $json["4"]["tbody"]["tr"]["1"]["td"]["1"]["content"];
		$capitalExpenditures = $json["4"]["tbody"]["tr"]["7"]["td"]["1"]["span"]["content"];
		$cashFromOperatingActivities = $json["4"]["tbody"]["tr"]["6"]["td"]["1"]["content"];


		//Push all of this into the array
		array_push($response, $revanueValue, $costOfRevanue, $operatingIncome, $netIncome, $netIncome, $dividendsPerShare, $dilutedNormalizedEps, $minorityInterest, $cashAndShortTermInvestments
			, $totalCurrentAssets, $totalAssets, $totalCurrentLiabilities, $totalLongTermDebt, $totalLiabilities, $totalEquity, $totalCommonSharesOutstanding, $preferredStockNonRedeemableNet
			, $deprecationDepletion, $capitalExpenditures, $cashFromOperatingActivities);

		/* ------------------------------- Financials --> Growths ------------------------*/
		
		//Revanue Growth Oldest year to newest year
		$jsonRevanue = $json["1"]["tbody"]["tr"]["0"]["td"];
		$revanueGrowth = array($jsonRevanue["4"]["content"], $jsonRevanue["3"]["content"], $jsonRevanue["2"]["content"], $jsonRevanue["1"]["content"]);

		//Diluted Normalized EPS - Oldest to latest year
		$dilutedNormalized = $json["1"]["tbody"]["tr"]["48"]["td"];
		$dilutedGrowth = [];

		array_push($dilutedGrowth, empty($dilutedNormalized["4"]["content"]) ? $dilutedNormalized["4"]["span"]["content"] : $dilutedNormalized["4"]["content"]);
		array_push($dilutedGrowth, empty($dilutedNormalized["3"]["content"]) ? $dilutedNormalized["3"]["span"]["content"] : $dilutedNormalized["3"]["content"]);
		array_push($dilutedGrowth, empty($dilutedNormalized["2"]["content"]) ? $dilutedNormalized["2"]["span"]["content"] : $dilutedNormalized["2"]["content"]);
		array_push($dilutedGrowth, empty($dilutedNormalized["1"]["content"]) ? $dilutedNormalized["1"]["span"]["content"] : $dilutedNormalized["1"]["content"]);

		//Dividends per share - Oldest to latest year
		$dividendsPerShareJson = $json["1"]["tbody"]["tr"]["35"]["td"];
		$dividendsPerShareGrowth = array($dividendsPerShareJson["4"]["content"], $dividendsPerShareJson["3"]["content"], $dividendsPerShareJson["2"]["content"], $dividendsPerShareJson["1"]["content"]);

		//Push this section to the response array

		array_push($response, $revanueGrowth, $dilutedGrowth, $dividendsPerShareGrowth);

		/* -------------------------------- Financials -> Tax Rates ------------------------*/

		//Income before tax - Oldest to latest year
		$beforeTaxJson = $json ["1"]["tbody"]["tr"]["16"]["td"];
		$incomeBeforeTax = [];

		array_push($incomeBeforeTax, empty($beforeTaxJson["4"]["content"]) ? $beforeTaxJson["4"]["span"]["content"] : $beforeTaxJson["4"]["content"]);
		array_push($incomeBeforeTax, empty($beforeTaxJson["3"]["content"]) ? $beforeTaxJson["3"]["span"]["content"] : $beforeTaxJson["3"]["content"]);
		array_push($incomeBeforeTax, empty($beforeTaxJson["2"]["content"]) ? $beforeTaxJson["2"]["span"]["content"] : $beforeTaxJson["2"]["content"]);
		array_push($incomeBeforeTax, empty($beforeTaxJson["1"]["content"]) ? $beforeTaxJson["1"]["span"]["content"] : $beforeTaxJson["1"]["content"]);

		//Income after tax - Oldest to latest year
		$afterTaxJson = $json["1"]["tbody"]["tr"]["17"]["td"];
		$incomeAfterTax = [];

		array_push($incomeAfterTax, empty($afterTaxJson["4"]["content"]) ? $afterTaxJson["4"]["span"]["content"] : $afterTaxJson["4"]["content"]);
		array_push($incomeAfterTax, empty($afterTaxJson["3"]["content"]) ? $afterTaxJson["3"]["span"]["content"] : $afterTaxJson["3"]["content"]);
		array_push($incomeAfterTax, empty($afterTaxJson["2"]["content"]) ? $afterTaxJson["2"]["span"]["content"] : $afterTaxJson["2"]["content"]);
		array_push($incomeAfterTax, empty($afterTaxJson["1"]["content"]) ? $afterTaxJson["1"]["span"]["content"] : $afterTaxJson["1"]["content"]);

		//Push this section to the response array

		array_push($response, $incomeBeforeTax, $incomeAfterTax);

		/* --------------------------- Financials -> More income stuff? -----------------------*/

		//Cost of Revenue - Oldest to latest year
		$costOfRevanue = [];

		array_push($costOfRevanue, empty($json["1"]["tbody"]["tr"]["3"]["td"]["4"]["content"]) ? $json["1"]["tbody"]["tr"]["3"]["td"]["4"]["span"]["content"] : $json["1"]["tbody"]["tr"]["3"]["td"]["4"]["content"]);
		array_push($costOfRevanue, empty($json["1"]["tbody"]["tr"]["3"]["td"]["3"]["content"]) ? $json["1"]["tbody"]["tr"]["3"]["td"]["3"]["span"]["content"] : $json["1"]["tbody"]["tr"]["3"]["td"]["3"]["content"]);
		array_push($costOfRevanue, empty($json["1"]["tbody"]["tr"]["3"]["td"]["2"]["content"]) ? $json["1"]["tbody"]["tr"]["3"]["td"]["2"]["span"]["content"] : $json["1"]["tbody"]["tr"]["3"]["td"]["2"]["content"]);
		array_push($costOfRevanue, empty($json["1"]["tbody"]["tr"]["3"]["td"]["1"]["content"]) ? $json["1"]["tbody"]["tr"]["3"]["td"]["1"]["span"]["content"] : $json["1"]["tbody"]["tr"]["3"]["td"]["1"]["content"]);

		array_push($response, $costOfRevanue);

		print_r($response);
	}



}
