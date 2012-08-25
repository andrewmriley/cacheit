<?PHP

#############################################################################
#                                                    class.CacheIt.php v3.1 #
# class.CacheIt.php                                                         #
# Copyright (c) 2000 Andrew Riley (boad@boaddrink.com)                      #
#                                                                           #
# This program is free software; you can redistribute it and/or             #
# modify it under the terms of the GNU General Public License               #
# as published by the Free Software Foundation; either version 2            #
# of the License, or (at your option) any later version.                    #
#                                                                           #
# This program is distributed in the hope that it will be useful,           #
# but WITHOUT ANY WARRANTY; without even the implied warranty of            #
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             #
# GNU General Public License for more details.                              #
#                                                                           #
# You should have received a copy of the GNU General Public License         #
# along with this program; if not, write to the Free Software               #
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307,    #
# USA.                                                                      #
#                                                                           #
#############################################################################
#                                                                           #
# If you run into any problems, pleas read the readme_cacheit.txt.          #
# If that does not help, check out http://www.boaddrink.com.                #
#                                                                           #
# For more info, please visit http://www.boaddrink.com or read the readme   #
# file included.                                                            #
#############################################################################


class CacheIt{
  
  var $root       = '';
  var $module_dir = '';
  var $tagit	   = true;
  var $cached     = array();
  var $modules    = array();
  
  function CacheIt($cache_dir,$module_dir,$tagit = true){ // Construct
    $this->root = $cache_dir;
    $this->module_dir = $module_dir;
    $this->tagit = $tagit;
    if($this->tagit) print "\n<!-- CacheIT v3.1 Init -->\n";
  } // Construct function
  
  function write_file($file_name,$contents){ // Internal
    $this->cached[$file_name] = $contents;
    $fp = @fopen($file_name,'w');
      if($this->tagit) @fwrite($fp,"<!-- Begin Cache ".date("Y/m/d H:i:s",time())." -->\n");
      @fwrite($fp,$contents);
      if($this->tagit) @fwrite($fp,"<!-- End Cache -->\n");
    @fclose($fp);
  } // Internal function
  
  function load_file($file_name){ // Internal
    $fp = fopen($file_name,'r');
      $this->cached[$file_name] = fread($fp,filesize($file_name));
    fclose($fp);
  } // Internal function
  
  function load_module($module){ // Internal
    if(!$this->modules[$module] && include($this->module_dir."/".$module.".php")) $this->modules[$module] = 1;
    return $this->modules[$module];
  } // Internal function
    
  function disp_file($cache_file,$f_f,$f_args = "",$time_out = 3600,$cache_method = 0){ // External
    $full_cache_file = $this->root."/".$cache_file;
    if(!$this->cached[$full_cache_file]){
      if($time_out == -1 && $this->load_module($f_f)) $this->cached[$full_cache_file] = $f_f($f_args);
      else {
        $ft = filemtime($full_cache_file);
        if(($ft != 0) && ((time()-$ft) < $time_out)) $this->load_file($full_cache_file);
        else {
          if($this->load_module($f_f)) $this->write_file($full_cache_file,$f_f($f_args));
        } // if
      } // if
    } // if
    print $this->cached[$full_cache_file];
    if(!$cache_method) unset($this->cached[$full_cache_file]);
  } // External function
    
} // class

?>