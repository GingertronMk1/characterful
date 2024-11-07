<?php

class DefaultLogin
{
    /** Print login form.
     */
    public function loginForm()
    {
        echo <<<'HTML'
<input name="auth[driver]" value="sqlite" />
<input name="auth[db]" value="data.db" />
<input name="auth[permanent]" type="checkbox" value="1" checked />
<input type="submit" value="Log In">
HTML;

        return 0;
    }

    public function login()
    {
        return true;
    }
}

return new DefaultLogin();
