import { Injectable } from '@angular/core';
import { Observable } from "rxjs";
import { HttpClient } from '@angular/common/http'

import { LoginResponse } from '../models/login-api';
import { Response } from '../models/events';

@Injectable({
  providedIn: 'root'
})
export class ApiRequestService {

  constructor(public http : HttpClient) { }

  login = "http://localhost:8000/api/login"
  events = "http://localhost:8000/api/events"

  public getLoginResponse($email : string, $password : string) : Observable<LoginResponse> {
    return this.http.post<LoginResponse>(this.login, { "email" : $email, "password" : $password })
  }

  public getEvents() : Observable<Response[]> {
    return this.http.get<Response[]>(this.events)
  }
}
