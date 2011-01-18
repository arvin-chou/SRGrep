<?php  
class infixtopostfix extends Model {  
	/*
	   Infix to Postfix Conversion
	   - Converts an Infix(Inorder) expression to Postfix(Postorder)
	   - For eg. '1*2+3' converts to '12*3+'
	   - Valid Operators are +,-,*,/
	   - No Error Handling in this version
	   JavaScript Implementation
	   - CopyRight 2002 Premshree Pillai
	   See algorithm at
	   -http://www.qiksearch.com/articles/cs/infix-postfix/index.htm
Created : 28/08/02 (dd/mm/yy)
Web : http://www.qiksearch.com
E-mail : qiksearch@rediffmail.com
	 */

	
	public $postfixStr;
	public $stackArr;
	public $postfixPtr;
	public $infixStr;
	function infixtopostfix()
	{
		parent::Model();
		$this->postfixStr=Array();
		$this->stackArr=Array();
		$this->postfixPtr=0;
	}
	function i2p($infixStr,$postfixStr)
	{
		//parent::Model();
		$this->infixStr=str_split($infixStr);
		//print_r($this->infixStr);
		for($i=0; $i<count($this->infixStr); $i++)
		{
			if($this->isOperand($this->infixStr[$i]))
			{
				$this->postfixStr[$this->postfixPtr]=$this->infixStr[$i];
				$this->postfixPtr++;
			}
			else
			{
				while((!$this->isEmpty($this->stackArr)) && ($this->prcd($this->topStack($this->stackArr),$this->infixStr[$i])))
				{
					$this->postfixStr[$this->postfixPtr]=$this->topStack($this->stackArr);
					$this->pop_stack($this->stackArr);
					$this->postfixPtr++;
				}
				if((!$this->isEmpty($this->stackArr)) && ($this->infixStr[$i]==")"))
				{
					$this->pop_stack($this->stackArr);
				}
				else
				{
					$this->push_stack($this->stackArr,$this->infixStr[$i]);
				}
			}
		}
		while(!$this->isEmpty($stackArr))
		{
			$this->postfixStr[count($this->postfixStr)]=$this->topStack($this->stackArr);
			$this->pop_stack($this->stackArr);
		}
		$returnVal='';
		for( $i=0; $i<count($this->postfixStr); $i++)
		{
			$returnVal.=$this->postfixStr[$i];
		}
		return($returnVal);
	}

	function push_stack(&$stackArr,$ele)
	{
		array_push($stackArr,$ele);
	}

	function pop_stack(&$stackArr)
	{
		$_temp=$stackArr[count($stackArr)-1];
		array_pop($stackArr);
		//stackArr.length--;
		return($_temp);
	}

	function isOperand($who)
	{
		return(!$this->isOperator($who)? true : false);
	}

	function isOperator($who)
	{
		return(($who=="+" || $who=="-" || $who=="*" || $who=="/" || $who=="(" || $who==")")? true : false);
	}

	function topStack($stackArr)
	{
		return($stackArr[count($stackArr)-1]);
	}

	function isEmpty(&$stackArr)
	{
		return((count($stackArr)==0)? true : false);
	}

	/* Check for Precedence */
	function prcd($char1,$char2)
	{
		 $char1_index = $char2_index = "";
		 $_def_prcd="-+*/";
		for( $i=0; $i<count($_def_prcd); $i++)
		{
			if($char1==strpos($_def_prcd,$i)) $char1_index=$i;
			if($char2==strpos($_def_prcd,$i)) $char2_index=$i;
		}
		if((($char1_index==0)||($char1_index==1)) && ($char2_index>1)) return false;
		else return true;
	}
}
?>
