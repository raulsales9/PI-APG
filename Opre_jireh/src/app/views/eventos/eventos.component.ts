import { Component} from '@angular/core';
import { Contents, contents } from './eventos.interface';
import { ApiRequestService } from "../../services/api-request.service";

@Component({
  selector: 'app-eventos',
  templateUrl: './eventos.component.html',
  styleUrls: ['./eventos.component.css']
})
export class EventosComponent {
  public number: number = 1;
  public contents : Contents[] = contents;
  public counter: number = 1;

  constructor (public service : ApiRequestService) { }

  ngOnInit()
  {
    
    this.service.getEventsResponse().subscribe(response =>{
      console.log(response);
      for (let i = 0; i < this.contents.length; i++) {

        this.contents[i] = {
          foto: "http://localhost:8000/assets/img/" + response[i].imagen,
          titulo: response[i].name,
          descripcion: response[i].description,
          horario: response[i].start_date.date + " - " + response[i].end_date.date,
          lugar: response[i].place,
          id: response[i].id
        };
        console.log(contents[i]);
        
      }

    });
  }




}
