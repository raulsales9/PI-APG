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
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';


import { EventComponent } from './views/eventos/event/event.component';
import { QuieneSomosComponent } from './views/quiene-somos/quiene-somos.component';
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
    EventComponent,
    QuieneSomosComponent
    
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    AppRoutingModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
