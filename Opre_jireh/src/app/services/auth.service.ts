import { Injectable } from '@angular/core';
import { LoginResponse } from '../models/login-api';
import {Router} from "@angular/router"
@Injectable({
  providedIn: 'root'
})
export class AuthService {

  isUserLoggedIn : boolean = false;

  constructor(private router: Router ) { }

  public login(user: LoginResponse)
  {
    this.isUserLoggedIn = true;
    localStorage.setItem('isUserLoggedIn', this.isUserLoggedIn ? "true" : "false")
    localStorage.setItem('userName', user.user)
    localStorage.setItem('email', user.email)
    localStorage.setItem('id', user.id.toString())

    if (localStorage.getItem('isUserLoggedIn') === "true") {
      this.router.navigate(['/home']);
    }else{
      alert("Usuario o contraseña incorrectos");
    }
  }

  public logOut() {
    this.isUserLoggedIn = false;
    localStorage.setItem('isUserLoggedIn', "false")
    localStorage.setItem('userName', "")
    localStorage.setItem('email', "")
    localStorage.setItem('id', "")
  }
}
