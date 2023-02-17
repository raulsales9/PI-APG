import { Component } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent {

  public home: number = 1;
  public contacto: number = 1;
  public perfil: number = 1;
  public eventos: number=1;
  public quienessomos:number=1;

  public userName : string | null = "Iniciar sesión";

  constructor (service : AuthService) { }

  ngOnInit()
  {
    if (localStorage.getItem('isUserLoggedIn') === "true") {
      this.userName = localStorage.getItem('userName');
    }
  }

  public onHome(): void {
    this.home = 2;
    this.contacto = 1;
    this.perfil = 1;
    this.eventos = 1;
    this.quienessomos = 1;
  }

  public onContacto(): void {
    this.home = 1;
    this.contacto = 2;
    this.perfil = 1;
    this.eventos = 1;
    this.quienessomos = 1;
  }

  public onPerfil(): void {
    this.home = 1;
    this.contacto = 1;
    this.perfil = 2;
    this.eventos = 1;
    this.quienessomos = 1;
  }

  public onEventos(): void {
    this.home = 1;
    this.contacto = 1;
    this.perfil = 1;
    this.eventos = 2;
    this.quienessomos = 1;

  }
  public onQuienessomos(): void {
    this.home = 1;
    this.contacto = 1;
    this.perfil = 1;
    this.eventos = 1;
    this.quienessomos = 2;

  }
}
