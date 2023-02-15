import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './components/header/header.component';
import { FooterComponent } from './components/footer/footer.component';
import { HomeComponent } from './views/home/home.component';
import { LoginComponent } from './views/login/login.component';
import { ContactoComponent } from './views/contacto/contacto.component';
import { SigninComponent } from './views/signin/signin.component';
import { EventosComponent } from './views/eventos/eventos.component';
import { NewsComponent } from './views/home/news/news.component';
<<<<<<< HEAD
import { EventComponent } from './views/eventos/event/event.component';
=======
import { FormsModule } from '@angular/forms';

>>>>>>> b4fa04d6493b71b6d068d5df6ce0a33f75e342da
@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    HomeComponent,
    LoginComponent,
    ContactoComponent,
    SigninComponent,
    EventosComponent,
    NewsComponent,
    EventComponent
    
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
