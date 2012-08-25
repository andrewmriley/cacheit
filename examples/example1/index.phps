<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF">
<?PHP
 
  include("../../class.CacheIt.php");
  
  $cache = new CacheIt("../cache","../modules");
  
  $cache->disp_file("example1.cache","module1",array(),-1);

?> 
</body>
</html>
