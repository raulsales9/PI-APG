import { Component } from '@angular/core';
import { ApiRequestService } from "../../services/api-request.service";
import { User, contents } from './user.interface';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent {

  constructor(public service: ApiRequestService) { }

  public perfil: number = 1;
  public contents: User = contents;
  public id: any = localStorage.getItem('id');

  public nombre : string = "";
  public apellidos : string = "";
  public telefono : string = "";
  public email : string = "";

  public peticio() {
    this.service.getUser(this.id).subscribe(response => {
      this.contents = {
        name: response.name,
        surname: response.surname,
        Email: response.Email,
        phone: response.phone,
        events: response.events,
      };
    });

  }

  ngOnInit() {
    this.perfil = 1;
    this.peticio();
  }

  public onClic() {
    this.perfil = 2;
  }

  public onSubmit() {
    this.service.updateUser(this.id, this.contents.name, this.contents.surname, this.contents.Email, this.contents.phone).subscribe(response => { });
    this.perfil = 1;
    this.peticio();
  }



}
