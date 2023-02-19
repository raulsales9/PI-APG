import { Component } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';
import { ApiRequestService } from "../../services/api-request.service";
import {Router} from "@angular/router"

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  email : string = "";
  password : string = "";

  constructor(public service : ApiRequestService, public Auth : AuthService, private router: Router ) { }

  onSubmit()
  {
    this.service.getLoginResponse(this.email, this.password).subscribe(response =>{
      if (typeof response === "object") {
        this.Auth.login(response)
      }else{
        // mensaje de error aquí
      }
    })
    
    if (localStorage.getItem('isUserLoggedIn') === "true") {
      this.router.navigate(['/home']);
    }else{
      alert("Usuario o contraseña incorrectos");
    }
  }


}
