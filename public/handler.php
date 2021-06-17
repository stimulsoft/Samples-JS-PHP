<?php

require_once 'autoloader.php';

// You can configure the security level as you required.
// By default is to allow any requests from any domains.

\header('Access-Control-Allow-Origin: *');
\header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Engaged-Auth-Token');
\header('Cache-Control: no-cache');

$handler = new \Stimulsoft\Handler();
$handler->registerErrorHandlers();

$handler->onPrepareVariables = function($args) {
	// You can change the values of the variables used in the report.
	// The new values will be passed to the report generator.
	/*
	$args->variables['VariableString']->value = 'Value from Server-Side';
	$args->variables['VariableDateTime']->value = '2020-01-31 22:00:00';

	$args->variables['VariableStringRange']->value->from = 'Aaa';
	$args->variables['VariableStringRange']->value->to = 'Zzz';

	$args->variables['VariableStringList']->value[0] = 'Test';
	$args->variables['VariableStringList']->value = ['1', '2', '2'];

	$args->variables['NewVariable'] = ['value' => 'New Value'];
	 */

	return \Stimulsoft\Result::success();
};

$handler->onBeginProcessData = function($args) {
	// Current database type: 'XML', 'JSON', 'MySQL', 'MS SQL', 'PostgreSQL', 'Firebird', 'Oracle'
	$database = $args->database;
	// Current connection name
	$connection = $args->connection;
	// Current data source name
	$dataSource = $args->dataSource;
	// Connection string for the current data source
	$connectionString = $args->connectionString;
	// SQL query string for the current data source
	$queryString = $args->queryString;


	// You can change the connection string
	/*
	if ($connection == 'MyConnectionName')
		$args->connectionString = 'Server=localhost;Database=test;uid=root;password=******;';
	 */

	// You can change the SQL query
	/*
	if ($dataSource == 'MyDataSource')
		$args->queryString = 'SELECT * FROM MyTable';
	 */


	// You can change the SQL query parameters with the required values
	// For example: SELECT * FROM @Parameter1 WHERE Id = @Parameter2 AND Date > @Parameter3
	/*
	if ($dataSource == 'MyDataSourceWithParams') {
		$args->parameters['Parameter1']->value = 'TableName';
		$args->parameters['Parameter2']->value = 10;
		$args->parameters['Parameter3']->value = '2019-01-20';
	}
	 */


	// You can send a successful result
	return \Stimulsoft\Result::success();
	// You can send an informational message
	//return \Stimulsoft\Result::success('Warning or other useful information.');
	// You can send an error message
	//return \Stimulsoft\Result::error('A message about some connection error.');
};

$handler->onPrintReport = function($args) {
	$fileName = $args->fileName; // Report file name

	return \Stimulsoft\Result::success();
};

$handler->onBeginExportReport = function($args) {
	// Export format
	$format = $args->format;
	// Export settions
	$settings = $args->settings;
	// Report file name
	$fileName = $args->fileName;

	return \Stimulsoft\Result::success();
};

$handler->onEndExportReport = function($args) {
	// Export format
	$format = $args->format;
	// Base64 export data
	$data = $args->data;
	// Report file name
	$fileName = $args->fileName;
	// Report file extension
	$fileExtension = $args->fileExtension;

	// By default, the exported file is saved to the 'reports' folder.
	// You can change this behavior if required.
	\file_put_contents('reports/' . $fileName . '.' . $fileExtension, \base64_decode($data));

	//return \Stimulsoft\Result::success();
	return \Stimulsoft\Result::success('Successful export of the report.');
	//return \Stimulsoft\Result::error('An error occurred while exporting the report.');
};

$handler->onEmailReport = function($args) {
	// These parameters will be used when sending the report by email. You must set the correct values.
	$args->settings->from = '******@gmail.com';
	$args->settings->host = 'smtp.gmail.com';
	$args->settings->login = '******';
	$args->settings->password = '******';

	// These parameters are optional.
	//$args->settings->name = 'John Smith';
	//$args->settings->port = 465;
	//$args->settings->cc[] = 'copy1@gmail.com';
	//$args->settings->bcc[] = 'copy2@gmail.com';
	//$args->settings->bcc[] = 'copy3@gmail.com John Smith';

	return \Stimulsoft\Result::success('Email sent successfully.');
};

$handler->onDesignReport = function($args) {
	return \Stimulsoft\Result::success();
};

$handler->onCreateReport = function($args) {
	// File name of the new report
	$fileName = $args->fileName;

	return \Stimulsoft\Result::success();
};

$handler->onSaveReport = function($args) {
	// Report object
	$report = $args->report;
	// Report in JSON format
	$reportJson = $args->reportJson;
	// Report file name
	$fileName = $args->fileName;

	// For example, you can save a report to the 'reports' folder on the server-side.
	\file_put_contents('reports/' . $fileName . '.mrt', $reportJson);

	//return \Stimulsoft\Result::success();
	return \Stimulsoft\Result::success('Save Report OK: ' . $fileName);
	//return \Stimulsoft\Result::error('Save Report ERROR. Message from server side.');
};

$handler->onSaveAsReport = function($args) {
	// The event works the same as 'onSaveReport'
	return \Stimulsoft\Result::success();
};


// Process request
$handler->process();
