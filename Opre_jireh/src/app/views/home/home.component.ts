import { Component} from '@angular/core';
import { contents } from './home.interface';
import { ApiRequestService } from "../../services/api-request.service";
import { News } from './home.interface';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']

})
export class HomeComponent {
  public number: number = 1;
  public contents : News[] = contents;
  public counter: number = 1;

  constructor (public service : ApiRequestService){}
  ngOnInit(){
    this.service.getNews().subscribe(response=>{

      for (let i = 0; i < this.contents.length; i++) {

        this.contents[i] = {
          imagen: "http://localhost:8000/assets/img/" + response[i].imagen,
          Titulo: response[i].Titulo,
          texto: response[i].texto
        };
        
      }

    });
  }
}
