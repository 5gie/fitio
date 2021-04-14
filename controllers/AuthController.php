<?php

namespace app\controllers;

use app\system\helpers\Filter;
use app\models\Approvals;
use app\system\Controller;
use app\models\User;
use app\models\Login;
use app\models\UserApprovals;

class AuthController extends Controller
{

    public function __construct() 
    {
        
        parent::__construct();
        
        $this->view->setLayout('auth');
    }

    public function activate($ckey)
    {

        $user = User::findOne(['ckey' => $ckey, 'status' => 0]);

        if($user){

            $model = new User;

            $model->data($user);
            $model->status = 1;
            $model->ckey = null;

            if($model->update(['id' => $user->id])){

                $this->session->setFlash('success', 'Twoje konto zostało aktywowane, możesz teraz się zalogować');
                
                $this->response->redirect('/logowanie');

            } else {

                $this->session->setFlash('danger', 'Wystąpił nieoczekiwany błąd, prosimy o kontakt z Administracją');

                $this->response->redirect('/');

            }

        } else {

            $this->session->setFlash('danger', 'Ten link jest już nieaktywny');

            $this->response->redirect('/');

        }

        return;

    }

    public function login()
    {

        if(!$this->checkNotAuth()) return;

        $login = new Login;

        if($this->request->post()){

            $login->data($this->request->body());
            if($login->validate() && $login->login()){

                $this->session->set('user', $login->id);

                $this->doRedirect('/konto');

                return;

            } else {

                $this->session->setFlash('danger', $login->getFirstError());

            }
        }

        return $this->view->render('auth/login', [
            'model' => $login
        ]);

    }


    public function logout()
    {

        if(!$this->checkAuth()) return;
        
        $this->session->remove('user');

        $this->response->redirect('/');

        $this->session->setFlash('info', 'Wylogowano pomyślnie');

        return;

    }

    public function register()
    {

        if(!$this->checkNotAuth()) return;

        $user = new User;

        $user->registerApprovals = Approvals::findAll([], ['id' => 'DESC']);

        if ($this->request->post()) {

            $user->data($this->request->body());

            $user->ckey = Filter::ckey();

            if($user->validate() && $user->validateEmail() && $user->save()){

                $userApprovals = new UserApprovals;
                $userApprovals->user_id = $user->id;
                $userApprovals->data($this->request->body());
                if(!$userApprovals->save()) error_log('Błąd przy dodawaniu user approvals');

                // TODO: wyslij email to uzytkownika

                $this->session->setFlash('success', 'Na podany adres e-mail została wysłana wiadomośc z potwierdzeniem akceptacji konta.');

                $this->response->redirect('/');

                return;
            
            } else {

                $this->session->setFlash('danger', $user->getFirstError());

            }

        }

        return $this->view->render('auth/register', [
            'model' => $user,
        ]);

    }

    public function reset()
    {

        if(!$this->checkNotAuth()) return;

        $user = new User;

        if ($this->request->post()) {

            $error = false;

            $user->data($this->request->body());

            if($user->email){

                $getUser = User::findOne(['email' => $user->email]);

                if($getUser){

                    $user->data($getUser);

                    $user->reset = 1;

                    $user->ckey = Filter::ckey();

                    if($user->update($user)){

                        $this->session->setFlash('info', 'Twoje hasło zostało zresetowane, na podany adres e-mail została wysłana wiadomość z potwierdzeniem');

                    } else $error = 'Wystąpił nieoczekiwany błąd, prosimy o kontakt z Administracją.';

                } else $error = 'Użytkownik o takim adresie e-mail nie istnieje';

            } else $error = 'Prosimy uzupełnić wszystkie dane.';

            if($error) $this->session->setFlash('danger', $error);

        }

        return $this->view->render('auth/reset', [
            'model' => $user,
        ]);

    }

    public function newPassword($ckey)
    {

        $user = User::findOne(['ckey' => $ckey, 'reset' => 1]);

        if($user){

            if($this->request->post()){

                $model = new User;

                $model->data($user);
                $model->passowrd = '';
                $model->passowrd2 = '';
                $model->data($this->request->post);

                if($model->validate() && $model->update(['id' => $user->id, 'ckey' => $ckey, 'reset' => 1])){

                    $this->session->setFlash('success', 'Twoje hasło zostało zaktualizowane, możesz teraz się zalogować');

                    $this->response->redirect('/logowanie');

                    return;

                } else {

                    $this->session->setFlash('error', $model->getFirstError());

                }

            }

            return $this->view->render('auth/reset');

        } else {

            $this->session->setFlash('error', 'Błędny adres url');

            $this->response->redirect('/');

        }

        return;

    }

}
