import { Injectable } from '@angular/core';
import { Observable } from "rxjs";
import { HttpClient } from '@angular/common/http'

import { LoginResponse } from '../models/login-api';
import { Response } from '../models/events';
import { RegisterResponse } from '../models/register';
import { News } from '../models/news';
@Injectable({
  providedIn: 'root'
})
export class ApiRequestService {

  constructor(public http : HttpClient) { }

  login = "http://localhost:8000/api/login"
  events = "http://localhost:8000/api/events"
  register = "http://localhost:8000/api/insert/user"
  news = "http://localhost:8000/api/news"

  public getLoginResponse($email : string, $password : string) : Observable<LoginResponse> {
    return this.http.post<LoginResponse>(this.login, { "email" : $email, "password" : $password })
  }

  public getEventsResponse() : Observable<Response[]> {
    return this.http.get<Response[]>(this.events)
  }

  public getNews() : Observable<News[]> {
    return this.http.get<News[]>(this.news)
  }

  public registerResponse(email : string, name : string, surnames: string, password : string, phone : string) : Observable<RegisterResponse> {
    return this.http.post<RegisterResponse>(this.register, {
      "name" : name,
      "email" : email,
      "phone" : phone,
      "surnames" : surnames,
      "password" : password
    });
  }
}
