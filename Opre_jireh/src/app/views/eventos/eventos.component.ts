import { Component} from '@angular/core';
import { contents } from './eventos.interface';

@Component({
  selector: 'app-eventos',
  templateUrl: './eventos.component.html',
  styleUrls: ['./eventos.component.css']
})
export class EventosComponent {
  public number: number = 1;
  public contents = contents;
  public counter: number = 1;

}
