import { Component } from '@angular/core';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent {
  public title :string="Hombre gitano inventa el latin"; 
  public paragraph: string = " Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eius soluta quia vitae nostrum impedit perferendis repudiandae ipsa illum nam iste modi ducimus, inventore et deserunt consectetur temporibus aliquid, autem ratione.";
  
}
