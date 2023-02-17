import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './views/home/home.component';
import { LoginComponent } from './views/login/login.component';
import { SigninComponent } from './views/signin/signin.component';
import { ContactoComponent } from './views/contacto/contacto.component';
import { EventosComponent } from './views/eventos/eventos.component';
import { QuieneSomosComponent } from './views/quiene-somos/quiene-somos.component';
import { PagenotfoundComponent } from './components/pagenotfound/pagenotfound.component';

const routes: Routes = [
  { path: 'home', component: HomeComponent },
  { path: 'login', component: LoginComponent },
  { path: 'signin', component: SigninComponent },
  { path: 'contacto', component: ContactoComponent },
  { path: 'quienessomos', component: QuieneSomosComponent },
  { path: '', redirectTo: 'home', pathMatch: 'full'},
  { path: 'eventos', component: EventosComponent },
  { path: '**', component: PagenotfoundComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
