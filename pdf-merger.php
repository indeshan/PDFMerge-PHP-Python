<?php

//URLs for downloading file
$urls = array("https://www.example.com/1.pdf",
"https://www.example.com/2.pdf",
"https://www.example.com/3.pdf",
"https://www.example.com/4.pdf",
"https://www.example.com/5.pdf",
"https://www.example.com/6.pdf",  
"https://www.example.com/7.pdf",
"https://www.example.com/8.pdf",
"https://www.example.com/9.pdf",
"https://www.example.com/10.pdf",
"https://www.example.com/11.pdf",
"https://www.example.com/12.pdf",
"https://www.example.com/13.pdf",
"https://www.example.com/14.pdf",
"https://www.example.com/15.pdf",
"https://www.example.com/16.pdf",
"https://www.example.com/17.pdf",
"https://www.example.com/18.pdf",
"https://www.example.com/19.pdf",
"https://www.example.com/20.pdf",  
"https://www.example.com/21.pdf",
"https://www.example.com/22.pdf",
"https://www.example.com/23.pdf",
"https://www.example.com/24.pdf",
"https://www.example.com/25.pdf"
);

$count = 10;
$urlCount=0;

$my_file = "completed.txt";
$handle = fopen($my_file, 'w'); //create file to keep the track of number of downloaded files.
fclose($handle);

$start = time();

echo "Starting PDF Fetching at: ".date("F d, Y h:i:s A"),PHP_EOL;

while(1)
{
   // Fetch the number of downloaded file.
   $fp = new SplFileObject($my_file, 'r');
   $fp->seek(PHP_INT_MAX);
   $initial = $fp->key();

   // To run multiple processes for downloading the files.
   for($i=0;$i<$count;$i++)
   {
       shell_exec("php fetch.php " . $urls[$urlCount]  . "  files/file" . $urlCount . "  > /dev/null 2> /dev/null &");
       $urlCount++;
   }

   // Fetch the number of currently downloaded files.
   $fp->seek(PHP_INT_MAX);
   $current = $fp->key();

   // To limit the number of file downloaded by each process.
   while($current<$initial+$count)
   {
       $fp->seek(PHP_INT_MAX);
       $current = $fp->key();
   }

   // To break from while when all the files are downloaded.
   if($urlCount>=count($urls))
       break;
}

echo "PDF Fetch completed at: ".date("F d, Y h:i:s A"),PHP_EOL;
echo time()-$start." sec to fetch 100 PDFs",PHP_EOL;
echo "Starting PDF merging at: ".date("F d, Y h:i:s A"),PHP_EOL;

// Execute the python script to merge all the files.
shell_exec("python merge.py");

echo "Completed PDF merging at: ".date("F d, Y h:i:s A"),PHP_EOL;
echo time()-$start." sec to fetch and merge 100 PDFs",PHP_EOL;
echo "Open file file://".__DIR__."/merged_pdf.pdf",PHP_EOL;
unlink($my_file);
array_map('unlink', glob("files/*.*"));
?>
