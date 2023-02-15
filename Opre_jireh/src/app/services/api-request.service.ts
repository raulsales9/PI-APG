import { Injectable } from '@angular/core';
import { Observable } from "rxjs";
import { HttpClient } from '@angular/common/http'

import { LoginResponse } from '../models/login-api';

@Injectable({
  providedIn: 'root'
})
export class ApiRequestService {

  constructor(public http : HttpClient) { }

  login = "http://localhost:8001/api/login"

  public getLoginResponse($email : string, $password : string) : Observable<LoginResponse[]> {
    return this.http.post<LoginResponse[]>(this.login, { "email" : $email, "password" : $password })
  }
}
