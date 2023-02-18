import { Component } from '@angular/core';
import { ApiRequestService } from "../../services/api-request.service";
import { User, contents } from './user.interface';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent {

  constructor (public service : ApiRequestService) { }

  public perfil: number = 1;
  public contents : User = contents;


  ngOnInit() {
    this.perfil = 1;
    this.service.getUser(1).subscribe(response => {
      this.contents = {
        name: response.name,
        surname: response.surname,
        Email: response.Email,
        phone: response.phone,
        events: response.events,
      };
      console.log(this.contents);
    });
  }

  public onClic() {
    this.perfil = 2;
  }

}
