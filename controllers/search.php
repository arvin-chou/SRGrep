<?php
class Search extends Controller {
	protected $data= array();
	protected $limit;
	function __construct()
	{
		parent::Controller();
		$this->data = array(
				'title' => 'Aeil\'s Search Engine',
				'heading' => 'My Heading',
				'message' => 'My Message',
				'url' => base_url()
				);
		$this->data['form_attributes'] = array( 'id' => 'searchform','method'=>'post');
		$form_checkbox = array('cy','cn','py','pn');
		foreach($form_checkbox as $v)
		{
			list($n,$v1) = str_split($v);
			$this->data['form_checkbox_'.$v] = 
				array(
						'name'        => $n,
						'value'       => $v1,
						'checked'     => ($v1 == 'y')?TRUE:FALSE,
						'type'       => 'radio'
					 );
		}
		$this->data['form_input'] = 
			array(
					'name'        => 's',
					'id'          => 's',
				 );

		$this->limit = 10;
	}
	function _keepstate($content,$c,$p)
	{
		$this->data['form_input']['value'] = $content;
		$this->data['form_checkbox_cy']['checked'] = $c == 'y' ?TRUE:FALSE;
		$this->data['form_checkbox_cn']['checked'] = $c == 'y' ?FALSE:TRUE;
		$this->data['form_checkbox_py']['checked'] = $p == 'y' ?TRUE:FALSE;
		$this->data['form_checkbox_pn']['checked'] = $p == 'y' ?FALSE:TRUE;
	}
	function result($content,$c,$p)
	{
		$this->_keepstate($content,$c,$p);
		$this->load->model('search_model');
		$this->data['r'] = 
			$this->search_model->getData(
					$content,$c,$p);//,$this->data['current'],$this->limit);
		//print_r($this->data['r']);
		$this->data['pages'] = (count($this->data['r']) > $this->limit)
			?count($this->data['r']) / $this->limit:0;
		$this->data['encrypt'] = 
			base_url()."index.php/search/GAISrecord/" ;
		$this->data['href'] = 
			base_url()."index.php/search/searchhref/" .$content . "/" . $c . "/" .$p . "/";
		$this->data['limit'] = $this->limit;
		$this->data['current']--;
		for($i=($this->data['current']+1)*$this->limit;$i<=count($this->data['r'])-1;$i++)
		{
				unset($this->data['r'][$i]);
				//echo "start c" . $i . "<br />";
		}
		for($i=0;$i<$this->data['current']*$this->limit-1;$i++)
		{
				unset($this->data['r'][$i]);
				//echo "start 0" . $i . "<br />";
		}
		$this->data['current']++;
		$this->load->view('SERP',$this->data);
	}
	function GAISrecord($e)
	{
		//$this->load->library('encrypt');
		//echo $this->encrypt->decode($e);
		$this->load->model('search_model');
		$this->load->helper('html');
		$pattern = ($this->search_model->patterno);
		$e = explode("|",$e);
		echo meta('Content-type', 'text/html; charset=utf-8', 'equiv');
		foreach($pattern as $k=>$v)
		{
			echo $v.":".str_replace("&sl","/",$e[$k])."<br />";
		}
	}
	function index()
	{
		$content=$this->input->post('s',TRUE);
			//$this->load->view('premiumseries');
		if(empty($content))
		{
			//redirect('/search/', 'location');      
						$this->load->view('premiumseries',$this->data);
		}
		else
		{
			$c = $this->input->post('c',TRUE);
			$p = $this->input->post('p',TRUE);
			$this->data['current'] = 1;
			$this->result($content,$c,$p);
			//redirect("/search/result/".$content."/".$c."/".$p);
			//$this->load->view('SERP',$this->search_model->gethtmlparam());
		}
		//$keyword = urlencode($this->input->get_post('keyword', TRUE));
		//if(empty($this->input->get_post('s', TRUE)))
		//{
		//	$data['page_title'] = 'Your title';
		//}
		//else
		//{
		//	$this->load->view('SERP',$data);
		//}
	}
	/*function _remap($method)
	{
		//if($method == 'search')$this->searchhref('1','1','1','1');
	}*/
	function searchhref($content,$c,$p,$current)
	{
		$this->data['current'] = $current;
		$this->result($content,$c,$p);
	}
	function _test($a,$b,$c)
	{
		echo "QQQQ" . $a . $b . $c;
		//$this->load->database();

	}
	function _search()
	{
		$content = $this->input->get_post('s', TRUE);
		$isCase= $this->input->get_post('c', TRUE);
		$isPre= $this->input->get_post('p', TRUE);

	
	}


}
?>
