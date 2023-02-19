import { Component, Input } from '@angular/core';
import { ApiRequestService } from 'src/app/services/api-request.service';

@Component({
  selector: 'app-event',
  templateUrl: './event.component.html',
  styleUrls: ['./event.component.css']
})
export class EventComponent {

  @Input() foto: string = "";
  @Input() titulo: string = "";
  @Input() descripcion: string = "";
  @Input() horario: string = "";
  @Input() lugar: string = "";
  @Input() id: number = 0;

  constructor(public service : ApiRequestService) { }

  apuntarEvento(id : number, event : MouseEvent)
  {
    if (localStorage.getItem('isUserLoggedIn') === "true") {
      let idEvent = id;
      let idUser = localStorage.getItem('id');

      this.service.assistEventResponse(idUser, idEvent).subscribe(response =>{
        this.apuntado(idEvent, event)
      });
    }
  }

  apuntado(idEvent : number, event : MouseEvent)
  {
    const button : HTMLButtonElement = <HTMLButtonElement>event.target;
    button.disabled = true;
    button.textContent = "APUNTADO"
  }
}
