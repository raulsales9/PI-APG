import { Component,Input } from '@angular/core';

@Component({
  selector: 'app-news',
  templateUrl: './news.component.html',
  styleUrls: ['./news.component.css']
})
export class NewsComponent {
  @Input() picture: string="";
  @Input() title: string ="";
  @Input() description: string ="";
}
