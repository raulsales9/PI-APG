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
      for (let i = 0; i < this.contents.length; i++) {
        let start_date = this.changeFormat(response[i].start_date.date);
        let end_date =  this.changeFormat(response[i].end_date.date);
        this.contents[i] = {
          foto: "http://localhost:8000/assets/img/" + response[i].imagen,
          titulo: response[i].name,
          descripcion: response[i].description,
          horario: start_date[0] + " - " + end_date[0],
          lugar: response[i].place,
          id: response[i].id
        };
        
      }

    });
  }

  changeFormat(date : any)
  {
    return date.split(" ");
  }




}
