import { Component } from '@angular/core';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent {

  public perfil: number = 1;

  ngOnInit() {
    this.perfil = 1;
  }

  public onClic() {
    this.perfil = 2;
  }

}
