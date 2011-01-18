<?php  
class search_model extends Model {  
  
	public $pattern = array();
    function search_model()  
    {  
        // Call the Model constructor  
        parent::Model();  
		$this->priority= array
			(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21);
		$this->pattern = array
			("U","H","F","y","l","L","s","t","T","k","d","B","cs","ps","et","tt","lt","as","il","dl","sl","xl");
		$this->patterno = array
			("","U","H","F","y","l","L","s","t","T","k","d","B","cs","ps","et","tt","lt","as","il","dl","sl","xl");
    }  
	function gethtmlparam()
	{
		$data = array(
				'title' => 'Aeil\'s Search Engine',
				'heading' => 'My Heading',
				'message' => 'My Message',
				'url' => base_url()
				);
		return $data;
	}
  
	function queryoptions($content,$c,$p,$v)
	{
		//ex:(apple & pie) | banana
		$contents = explode("(",preg_replace("/(\*|\+|\)|\-|\/)/","",$content));
		$matched = Array();
		$poes = FALSE;
		$pos = FALSE;
		if( $p == 'y')
		{
			mb_internal_encoding('UTF-8');
			//if($t === $k)echo $k;
			//if(mb_ereg_match($content,$v)) 
				//echo "PPP<br/>";
			$pre = explode(" ",$v);
			if($c == 'y')
			{
				if(count($contents) == 1)
					foreach($pre as $k)
						if($content === $k)$pos++;
				else
					foreach($pre as $k)
						if(in_array($k,$contents))
							if(!in_array($k,$matched))
								array_push($matched,$k);
			}
			else
			{
				if(count($contents) == 1)
					foreach($pre as $k)
						if(strcasecmp($k,$content)== 0)$pos++;
				else
					foreach($pre as $k)
						foreach($contents as $co)
							if(strcasecmp($k,$co)== 0)
								array_push($matched,$k);
			}
			if(count($contents) >  1)
			{
				$patterns = $replaces = array();
				array_push($patterns,'/&/','/or/');
				array_push($replaces,'|','|');
				$content=str_replace(')','#)#' , $content);
				$content=str_replace('(',')' , $content);
				$content=str_replace('#)#','(' , $content);
				$contents = preg_replace($patterns, $replaces, $content);
				preg_match($contents,$matched,$m);
				if(count($m[1])>0)$pos = count($m[1]);
				else $pos=FALSE;
			}
		}
		else
		{
			$pattern = "/".$content."/";
			$pattern .= $c == 'y' ? "" : "i";
			preg_match_all($pattern,$v,$matches);
			$pos = (count($matches[0]) == 0) ? FALSE : count($matches[0]); 
		}
		return $pos;
	}
    function getData($content,$c,$p)
	{  
		//Query the data table for every record and row  

		//if ($query->num_rows() > 0)  
		//{  
		//	//show_error('Database is empty!');  
		//}else{  
		//	return $query->result();  
		//}  
		$this->load->helper('file');
		$this->load->helper('string');
		$this->load->library('typography');
		$ci =& get_instance();
		$ci->load->model('infixtopostfix');
		$content = $ci->infixtopostfix->i2p($content,"arr");
		$patterns = $replaces = array();



		$string = explode("@\n",read_file('./record/record_74MB'));
		//$string = explode("@\n",read_file('./record/recode_test'));
		unset($string[0]);
				//$content = "AEWIN";
		$r = $r1 = Array();
		foreach($string as $s)
		{
			//echo count($s,COUNT_RECURSIVE);
			//print_r($s);
			$match = FALSE;
			$score = 0;
			foreach(preg_split('/\n@/',$s) as $k=>$v)
			{
				$v = preg_replace('/^.{1,2}:/','',$v);
				//echo $v . "<br />";
				$pos = $this->queryoptions($content,$c,$p,$v);
				if ($pos === false) {}
				else
				{
					//echo $k."||".$v."||".$pos;
					$match = TRUE;
					$score += $this->priority[$k] * $pos; 
					//echo $score ."|".$pos."|".$this->priority[$k]. "<br />";
				}
				//echo $v."<br/>";
				//$r1[$this->pattern[$k]] = preg_replace('/^@\w+:/','',urlencode($v));
				if(array_key_exists($k,$this->pattern))
				$r1[$this->pattern[$k]] = preg_replace('/(\\r|\\n)/',' ',urlencode($v));
				//$r1[$this->pattern[$k]] = preg_replace('/^@.{,2}:/','',htmlspecialchars($v));
			}
			if($match)
			{
				//array_push($r,array($r1,$score));
				$r1['score'] = $score;
				$r1['encrypt'] = "";
				foreach($r1 as $k=>$e)
				{
					//echo $k."=>".($e) . "<br />";
					if($k != "B")
					$r1['encrypt'].= "|".$e;
				}
				$r1['encrypt'] = addslashes(
						$this->typography->
						format_characters(str_replace("/","&sl",urlencode($r1['encrypt']))));
				//$r1['encrypt'] = $encrypt;//$this->encrypt->encode($r1['encrypt']);
				//echo $r1['encrypt'];
				array_push($r,$r1);
				//$r[] = array($r1,$score);
				//print_r($r);
			}
			
			//echo $this->pattern->cs . "EEE";
			//echo "<pre>";
			//preg_match($content, preg_split('/\n@/',$s), $matches);
//print_r($matches);
			//echo ( array_search($content,preg_split('/\n@/',$s)));
			//print_r ( preg_split('/\n@/',$s));
			//print_r( $s);
			//echo "</pre>";
			//echo  "SSSS";
		}
		if(!empty($r))$this->getsort($r);
		//preg_match_all("/Co|(T|A)/","T:AEWIN Technologies Co., Ltd.AEWINAEWINAEWINAEWINAEWINAEWINAEWINAEWINAEWIN",$matches);
		//$pre = explode(" ","T:AEWIN Technologies Co., Ltd.AEWINAEWINAEW    INAEWINAEWINAEWINAEWINAEWINAEWIN");
		//$t = "t:aEWIN";
		////print_r($pre);
		//foreach($pre as $k)
		//{
		//	if(strlen($k)>=strlen($t))
		//	{
		//		//echo strcasecmp($k,$t);
		//		//echo "{".strlen($k)."|".strlen($t)."}".substr_compare($k,$t,0,strlen($t),FALSE);
		//	}
		//	//if($t === $k)echo $k;
		//}
		//echo "<br/>\n".count($matches,COUNT_RECURSIVE) . var_dump($matches) . "EE";
		//echo print_r($matches) . "EE";
		return $r;
	}  
	function getsort(&$r)
	{
		foreach($r as $k=>$v)
		{
			$orgk[$k] = $k;
			$score[$k] = $v['score'];
		}
		array_multisort($score,SORT_DESC,$orgk,SORT_ASC,$r);
			//echo "<pre>";
		//print_r($r);
		//echo 
		
		//print_r($r);
		
	//echo "</pre>";
	}
  
}  
?>  

