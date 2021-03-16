<?php

use app\models\Usuarios;
use tests\unit\fixtures\UsuariosFixture;

class LoginFormCest
{
    public function _fixtures()
    {
        return [
            [
                'class' => UsuariosFixture::class,
            ],
        ];
    }

    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Login', 'h1');

    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see('Logout (vaca.roberto)');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs(Usuarios::findOne(['nombre' => 'vaca.roberto']));
        $I->amOnPage('/');
        $I->see('Logout (vaca.roberto)');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Username no puede estar vacío.');
        $I->see('Password no puede estar vacío.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'vaca.roberto',
            'LoginForm[password]' => 'vaca.roberto',
        ]);
        $I->see('Logout (vaca.roberto)');
        $I->dontSeeElement('form#login-form');              
    }
}
