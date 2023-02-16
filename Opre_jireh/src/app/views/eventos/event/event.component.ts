import { Component, Input } from '@angular/core';

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

}
