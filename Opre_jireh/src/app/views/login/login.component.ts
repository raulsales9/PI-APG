import { Component } from '@angular/core';
import { ApiRequestService } from "../../services/api-request.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  email : string = "";
  password : string = "";

  constructor(public service : ApiRequestService ) { }

  onSubmit()
  {
    this.service.getLoginResponse(this.email, this.password).subscribe(response =>{
      alert(response);
    })
  }


}
