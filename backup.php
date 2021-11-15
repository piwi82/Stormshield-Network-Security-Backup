<?php

# Copyright (C) 2021, Piwi <https://github.com/piwi82>
# All rights reserved.
#
# SNS-Backup is free software: you can redistribute it and/or modify
# it under the terms of the GNU Lesser General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# SNS-Backup is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Lesser General Public License for more details.
#
# You should have received a copy of the GNU Lesser General Public License
# along with snspoliciestocsv.  If not, see <http://www.gnu.org/licenses/>.



// Allowed source IP addresses
$source = [
	'192.0.2.1',
	'192.0.2.2'
];

// Name must be the same as in SNS Configuration > System > Maintenance > Backup > Advanced configuration > POST - control name
$name = 'controlName';



// Logging function
function logToFile(string $message,string $file = 'backup.log',bool $exit = FALSE){
	$date = (new DateTime)->format('Y-m-d H:i:s.u');
	$filePutContents = file_put_contents($file,"{$date}\t$message\n",FILE_APPEND);
	if (TRUE===$exit) 
		exit;
	return $filePutContents;
}

// IP addresses whitelist
$remoteAddr = $_SERVER['REMOTE_ADDR'];
if (TRUE!==in_array($remoteAddr,$source)){
	header('HTTP/1.0 403 Forbidden',TRUE,403);
	exit;
}

// Check HTTP request method
$method = $_SERVER['REQUEST_METHOD'];
if ('POST'!=$method)
	logToFile("Bad HTTP request method '{$method}'",TRUE);

// Check backup file is present
if (1!=count($_FILES))
	logToFile("Backup file not found",TRUE);

// Check name length
if (0==strlen($name))
	logToFile("PHP \$name must be at least 1 character long",TRUE);

// Check name consistency
if (TRUE!==array_key_exists($name,$_FILES))
	logToFile("PHP \$name and SNS 'POST - control name' values must match",TRUE);

// Copy uploaded file
$copy = move_uploaded_file($_FILES[$name]['tmp_name'],$_FILES[$name]['name']);
$message = sprintf(
	(TRUE===$copy
		? 'Success: Configuration from %s to %s has been saved'
		: 'Failure: Configuration from %s to %s has not been saved'
	),
	$remoteAddr,
	$_FILES[$name]['name']
);
logToFile($message);

?>
