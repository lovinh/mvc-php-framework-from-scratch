<?php
class ParamsMiddleware extends BaseMiddleware
{
    public function handle()
    {
        if (path_info() == "/home/search")
            return;
        if (!empty($this->request->query_string)) {
            $this->response->redirect(Route::get_full_url());
        }
    }
}
