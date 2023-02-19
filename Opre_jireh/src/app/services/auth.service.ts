import { Injectable } from '@angular/core';
import { LoginResponse } from '../models/login-api';
@Injectable({
  providedIn: 'root'
})
export class AuthService {

  isUserLoggedIn : boolean = false;

  constructor() { }

  public login(user: LoginResponse)
  {
    this.isUserLoggedIn = true;
    localStorage.setItem('isUserLoggedIn', this.isUserLoggedIn ? "true" : "false")
    localStorage.setItem('userName', user.user)
    localStorage.setItem('email', user.email)
    localStorage.setItem('id', user.id.toString())
  }

  public logOut() {
    this.isUserLoggedIn = false;
    localStorage.setItem('isUserLoggedIn', "false")
    localStorage.setItem('userName', "")
    localStorage.setItem('email', "")
    localStorage.setItem('id', "")
  }
}
