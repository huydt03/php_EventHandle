<?php namespace Huydt\Libs;

class EventHandleItem
{
	private $fns = [];

	public function add($fn){
		array_push($this-> fns, $fn);
	}

	public function fire($data = null){
		foreach ($this-> fns as $value) {
			$value($data);
		}
	}

	public function remove($fn){
		foreach ($this-> fns as $key => $value) {
			if($value === $fn)
				unset($this-> fns[$key]);
		}
	}

	public function clear(){
		$this-> fns = [];
	}
}
 
class EventHandle
{

	protected $handle = [];

	function __construct($hooks = [])
	{
		$this-> initHooks($hooks);
		$this-> handle['add'] = function($hooks = []){ 
			$this-> initHooks($hooks); 
		};
		$this-> handle['listen'] = function($hook, $fn){ 
			$this-> initHandle($hook);
			$this-> {"$hook"} = $fn;
		};
	}

	private function initHooks($hooks = []){
		foreach ($hooks as $hook) {
			$this-> initHandle($hook);
		}
	}

	private function initHandle($hook){
		$this-> handle[$hook] = new EventHandleItem;
	}

	public function __set($name,$value) {
		if(isset($this-> handle[$name])){
			if(gettype($value) === 'object')
		    	$this-> handle[$name]-> add($value);
		    else
		    	echo "$value isn't a function!";
		}
	}
}