import { Component,Input } from '@angular/core';

@Component({
  selector: 'app-news',
  templateUrl: './news.component.html',
  styleUrls: ['./news.component.css']
})
export class NewsComponent {
  @Input() imagen: string="";
  @Input() Titulo: string ="";
  @Input() texto: string ="";
}
