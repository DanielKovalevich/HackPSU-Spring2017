<?php

namespace gchart;
ini_set('display_errors', '1');

function createAccountBalanceChart($dataSet, $legend, $colors) {

	$lineChart = new gLineChart(300,300);
	$lineChart->addDataSet($dataSet);
	$lineChart->setLegend($legend);
	$lineChart->setColors($colors);
	$lineChart->setVisibleAxes(array('x','y'));
	$lineChart->setDataRange(30,400);
	$lineChart->addAxisRange(0, 1, 4, 1);
	$lineChart->addAxisRange(1, 30, 400);

	$lineChart->addBackgroundFill('bg', 'EFEFEF');
	$lineChart->addBackgroundFill('c', '000000');

	print_r($lineChart->getUrl());
	return $lineChart;
}