<?php
/**
 * REST server for ferry schedule operations.
 * This one manages ports.
 *
 * ------------------------------------------------------------------------
 */
require APPPATH . '/third_party/restful/libraries/Rest_controller.php';
//require_once APPPATH . '/third_party/restful/libraries/Format.php';
class Maintenance extends Rest_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('menu');
	}
	// Handle an incoming GET ... 	returns a list of ports
	function index_get()
	{
        $key = $this->get('code');
        if (!$key)
        {
            $this->response($this->menu->all(), 200);
        } else
        {
            $result = $this->menu->get($key);
            if ($result != null)
                $this->response($result, 200);
            else
                $this->response(array('error' => 'Menu item not found!'), 404);
        }
    }

    // Handle an incoming GET ... return 1 menu item
    function item_get()
    {
        $key = $this->get('id');
        $result = $this->menu->get($key);
        if ($result != null)
            $this->response($result, 200);
        else
            $this->response(array('error' => 'Menu item not found!'), 404);        
    }
	
    // Handle an incoming POST - add a new menu item
    function index_post()
    {
        $key = $this->get('code');
        $record = array_merge(array('code' => $key), $_POST);
        $this->menu->add($record);
        $this->response(array('ok'), 200);
    }
    
    // Handle an incoming PUT - update a menu item
    function index_put()
    {
        $key = $this->get('code');
        $record = array_merge(array('code' => $key), $this->_put_args);
        $this->menu->update($record);
        $this->response(array('ok'), 200);
    }

    // Handle an incoming DELETE - delete a menu item
    function index_delete()
    {
        $key = $this->get('code');
        $this->menu->delete($key);
        $this->response(array('ok'), 200);
    }

}