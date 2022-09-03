<?php
$license='
    AsbraSMS v1.0 is a frontend for smstools
    Copyright (C) 2019 Nimpen J. Nordström <j@asbra.nu>
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation version 3.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
    ';
$phone   = $_REQUEST['phone'] ?? '';
$message = $_REQUEST['message'] ?? '';
$date    = date("ymd_His");
if ( ! empty ( $phone ) && ! empty ( $message ) )
{
  $content="To: $phone\n\n$message";
  echo "Sending...\n" . $content;
 // convert message to SMS for cyrillic support
  $content=iconv("utf-8","windows-1251", $content);
  file_put_contents("smsd/outgoing/$date.txt", $content);
}
else {
  echo "\nError: Missing parameters!\n\n";
  echo "Example: curl 'http://sms.your.domain/index.php?phone=%2B46720437607&message=test+from+terminal' > /dev/null\n";
  echo "Where %2B is UNICODE for the plus sign '+', use it to prefix the mobile number with a country code.\n\n";
  echo "$license\n\n";
}
?>
