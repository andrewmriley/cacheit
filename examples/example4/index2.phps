<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF">
<?PHP
 
  include("../../class.CacheIt.php");
  
  $cache = new CacheIt("../cache","../modules");
  
  $cache->disp_file("example4a.cache","module2",array("your_name"=>$your_name),-1,1); ?>
<br>
<?PHP $cache->disp_file("example4a.cache","module2",array("your_name"=>$your_name),-1); ?>
<br>
<?PHP $cache->disp_file("example4b.cache","module2",array("your_name"=>"Boad Drink!"),-1); ?>
</body>
</html>
