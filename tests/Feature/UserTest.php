<?php

use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase {

  public function testRegister() {
    
    $request = $this->createMock(Request::class);
      
    $controller = new UserController();
    $response = $controller->Register($request);
    
    $this->assertEquals(201, $response->getStatusCode());
    $this->seeInDatabase('users', [
      'name' => $request->post('name'),
      
    ]);
  }

  public function testLogin() {

    $user = factory(User::class)->create();
    $request = $this->createMock(Request::class);
    $request->shouldReceive('only')->andReturn([
      'email' => $user->email,
      'password' => 'password'
    ]);

   
    $controller = new UserController();
    $response = $controller->login($request);

  
    $this->assertEquals(200, $response->getStatusCode());
    $this->seeJsonStructure([
      'token'
    ]);
  }

  public function testLogout() {
  
    $user = factory(User::class)->create();
    $request = $this->createMock(Request::class);
    $request->shouldReceive('user')->andReturn($user);

    $controller = new UserController();
    $response = $controller->Logout($request);
 
    $this->seeJson([
      'message' => 'Token Revoked'
    ]);
    $this->assertDatabaseMissing('personal_access_tokens', [
      'tokenable_id' => $user->id
    ]);
  }

  public function testCreateUser() {
   
    $request = $this->createMock(Request::class);

    $userController = new UserController(); 
    $userController->createUser($request);

    $this->assertDatabaseHas('users', [
      'name' => $request->post('name'), 

    ]);
  }

  public function testCreateUserValidation() {
   
    $request = $this->createMock(Request::class);
    $request->expects($this->once())
            ->method('post')
            ->with('name')
            ->willReturn(null);
    
  
    $userController = new UserController();
    
   
    $this->expectException(ValidationException::class);
    $userController->createUser($request);
  }
  

  
}

