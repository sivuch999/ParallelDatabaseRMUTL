<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

function getSuggest(){
	$stockURL1="http://pantip.com/forum/siliconvalley";
	$html1 = file_get_contents($stockURL1);
	$dom1 = new DOMDocument('1.0', 'UTF-8');
	$dom1->loadHTML($html1);
	$xpathProcessor1 = new DOMXPath($dom1);
			$xpathQueryToStockTitle1 = "//div[@class='data-roomMenu-item' and @id='item_pantip-best_room']//div[@class='post-item-title']/a/text()";
			$title_results1 = $xpathProcessor1->query($xpathQueryToStockTitle1);

			$xpathQueryToStockTitle2 = "//div[@class='data-roomMenu-item' and @id='item_pantip-best_room']//div[@class='post-item-title']/a/@href";
			$title_results2 = $xpathProcessor1->query($xpathQueryToStockTitle2);
			$length = $title_results1->length;

					$dbhost = "localhost";
					$dbname = "pantip";
					$dbusername = "root";
					$dbpassword = "";

					$connection = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbusername,$dbpassword);
					$connection -> exec('SET NAMES utf8');
                    $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$statement = $connection->prepare("insert into db_pantip (id, title, link, post_by, time_stamp, number_of_comments, tags, emotion)
    							VALUES(:id, :title, :link, :post_by, :time_stamp,
    								:number_of_comments, :tags, :emotion)");

		for($i=0 ; $i<$length ;$i++){
			$title = $title_results1->item($i)->nodeValue;
			echo "กระทู้แนะนำที่ =".($i+1)."<br> ชื่อกระทู้ = $title<br>";

			$link = $title_results2->item($i)->nodeValue;
			echo "ลิงค์ = $link<br>";

			try {
					$statement->execute(array(
								"id" => $i+1, 
								"title" => $title,
                                "link" => $link,
								"post_by" => $post_by, 
								"time_stamp" => $time_stamp, 
								"number_of_comments" => $number_of_comments, 
								"tags" => $tags,
                                "emotion" => $emotion
								));
					$connection = null;
					
				}catch (PDOException $e) {
                     echo "get into catch <br>";
    				print "Error!: " . $e->getMessage() . "<br/>";
    				die();
				}
				echo "---------------------------------------------------------------------------------<br>";
		}	
}

function getEmotion($link){

	$stockURL1="http://pantip.com$link";
	echo "stockURL1 = $stockURL1 <br>";
	$html1 = file_get_contents($stockURL1);
	$dom1 = new DOMDocument('1.0', 'UTF-8');
	$dom1->loadHTML($html1);
	$xpathProcessor1 = new DOMXPath($dom1);
	$xpathQueryScore = "//a[@class='emotion-vote']/span[2]/text()";
	$title_results1 = $xpathProcessor1->query($xpathQueryScore);
	$i = 0;

	foreach ($title_results1 as $title_list1){
			$i++;
			$post_by = $title_list1->nodeValue;
			echo "emotion-score  =$post_by<br>";
	}
	return 	$post_by;
}

function functionmain(){
	$a[3]; $b[3];$d=0;
	for($x=1;$x<=1;$x++){
		if($x=1){    
		$xpathQueryString ="http://pantip.com/forum/siliconvalley"; 
                        $b[$x]=$xpathQueryString;
						geturl($b,$d);
		}
	}
}
function geturl($b,$d){
	$a[3]; $b[3]; $j;
	for($x=1;$x<=1;$x++){
		if($x=1 ){
		$stockURL1 ="$b[$x]";
		$html1 = file_get_contents($stockURL1);
		$dom1 = new DOMDocument('1.0', 'UTF-8');
		$dom1->loadHTML($html1);
		$xpathProcessor1 = new DOMXPath($dom1);
		$xpathQueryString1 = "//div[@class='loadmore-bar indexlist']/a/@href";
		$next_link_results1 = $xpathProcessor1->query($xpathQueryString1);
			for($y=1;$y<=1;$y++){
				foreach ($next_link_results1 as $title_list1){
					$title1 = $title_list1->nodeValue;
					$a[$y]="http://pantip.com$title1";
					}
					$m=$y;
			}
		for($n=1 ;$n<=50; $n++){
			$xpathQueryToStockTitle1 = "//div[@class='post-list-wrapper' and @id='show_topic_lists']/div[$n]/div[2]/a/text()";
			$title_results1 = $xpathProcessor1->query($xpathQueryToStockTitle1);
			$i = 0;
				foreach ($title_results1 as $title_list1){
					$i++;
					$title = $title_list1->nodeValue;
					echo "กระทู้ที่ =".($n+$d)."<br> ชื่อกระทู้ = $title<br>";
				}

			$k=($n+$d);
			$xpathQueryToStockTitle1 = "//div[@class='post-list-wrapper' and @id='show_topic_lists']/div[$n]/div[2]/a/@href";
			$title_results1 = $xpathProcessor1->query($xpathQueryToStockTitle1);
			$i = 0;
				foreach ($title_results1 as $title_list1){
					$i++;
					$link = $title_list1->nodeValue;
					echo "ลิงค์  =$link<br>";
				}    

			$xpathQueryToStockTitle1 = "//div[@class='post-list-wrapper' and @id='show_topic_lists']/div[$n] /div[3]";
			$title_results1 = $xpathProcessor1->query($xpathQueryToStockTitle1);
			$i = 0;
				foreach ($title_results1 as $title_list1){
					$i++;
					$post_by = $title_list1->nodeValue;
					echo "ชื่อผู้โพส  =$post_by<br>";
				}

			$xpathQueryToStockTitle1 = "//div[@class='post-list-wrapper' and @id='show_topic_lists']/div[$n]/div[3]/span/abbr/@data-utime";
			$title_results1 = $xpathProcessor1->query($xpathQueryToStockTitle1);
			$i = 0;
				foreach ($title_results1 as $title_list1){
					$i++;
					$time_stamp = $title_list1->nodeValue;
					echo "เวลาที่ตั้งกระทู้ =$time_stamp<br>";
				}	
		
			$xpathQueryToStockTitle1 = "//div[@class='post-list-wrapper' and @id='show_topic_lists']/div[$n]/div[3]/div/@title";
			$title_results1 = $xpathProcessor1->query($xpathQueryToStockTitle1);
			$i = 0;
				foreach ($title_results1 as $title_list1){
					$i++;
					$number_of_comments = $title_list1->nodeValue;
					echo "จำนวนความคิดเห็น  =$number_of_comments<br>";
				}
	    	
			$xpathQueryToStockTitle1 = "//div[@class='post-list-wrapper' and @id='show_topic_lists']/div[$n]/div[4]/div";
			$title_results1 = $xpathProcessor1->query($xpathQueryToStockTitle1);
			$i = 0;
				foreach ($title_results1 as $title_list1){
					$i++;
					$tags = $title_list1->nodeValue;
					echo "Tag ข้อมูล   =$tags<br>";
			}
			$emotion = getEmotion($link);

//--------------------START insert into db--------------
        	try {
    		$dbhost = "localhost";
			$dbname = "pantip";
			$dbusername = "root";
			$dbpassword = "";

			$connection = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbusername,$dbpassword);
			$connection -> exec('SET NAMES utf8');
			$connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$statement = $connection->prepare("insert into db_pantip (id, title, link, post_by, time_stamp, number_of_comments, tags, emotion)
    							VALUES(:id, :title, :link, :post_by, :time_stamp, :number_of_comments, :tags, :emotion)");
			$statement->execute(array(
								"id" => $n+$d, 
								"title" => $title,
                                "link" => $link,
								"post_by" => $post_by, 
								"time_stamp" => $time_stamp, 
								"number_of_comments" => $number_of_comments, 
								"tags" => $tags,
                                "emotion" => $emotion
								));
					$connection = null;
					
				}catch (PDOException $e) {
                     echo "get into catch <br>";
    				print "Error!: " . $e->getMessage() . "<br/>";
    				die();
				}
//--------------------END insert into db--------------
            
			if($k>199){
				exit();
			}
			echo "---------------------------------------------------------------------------------<br>";
		}
						$x=$m;
						//echo "<br>"."$a[$x]";
						$b[$x]="$a[$x]"."<br>";
						$j=($d+50);
						geturl($b,$j);
		}
	}
}


//////////////////////////////////////////////////////////
	getSuggest();
	functionmain();
	//test($s,$x);
	geturl($b,$d);
//////////////////////////////////////////////////////////
?>
