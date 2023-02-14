import { Component, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-eventos',
  templateUrl: './eventos.component.html',
  styleUrls: ['./eventos.component.css']
})
export class EventosComponent {
  @Input() foto: string = "";
  @Input() titulo: string = "";
  @Input() descripcion: string = "";

}
