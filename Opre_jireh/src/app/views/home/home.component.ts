import { Component} from '@angular/core';
import { contents } from './home.interface';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent {
  public number: number = 1;
  public contents = contents;
  public counter: number = 1;
}
