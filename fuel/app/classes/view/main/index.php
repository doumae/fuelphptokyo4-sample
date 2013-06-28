<?php

class View_Main_index extends ViewModel
{
    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */
    public function view()
    {
        $this->msg = 'これはViewModelで表示しています！';
    }
}
