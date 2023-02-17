import { Component } from '@angular/core';
import { ApiRequestService } from "../../services/api-request.service";
import {Router} from "@angular/router"


@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent {

 email : string = "";
 name : string = "";
 surnames : string = "";
 password : string = "";
 confirmPassword : string = "";
 phone : string = "";

  constructor(public service : ApiRequestService, private router: Router ) { }

  public onSubmit()
  {
    if (this.password === this.confirmPassword) {
      this.service.registerResponse(this.email, this.name, this.surnames, this.password, this.phone).subscribe(response =>{
        this.router.navigate(['/login'])
      });
    }else{
      alert("Las contraseñas no coinciden.")
    }
  }
}
