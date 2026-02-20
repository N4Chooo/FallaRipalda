import { Routes } from '@angular/router';
import { Gestion } from './views/gestion/gestion';
import { Iniciarsesion } from './views/iniciarsesion/iniciarsesion';
import { Noticias } from './views/noticias/noticias';
import { Register } from './views/register/register';
import { Index } from './views/index';
import { authGuard } from './guards/auth-guard';
import { Fallas } from './views/fallas/fallas';
import { adminGuard } from './guards/admin-guard';

export const routes: Routes = [
    { path: '', redirectTo: 'index', pathMatch: 'full' },
    { path: 'index', component: Index },
    { path: 'gestion', component: Gestion,canActivate: [adminGuard]},
    { path: 'login', component: Iniciarsesion },
    { path: 'noticias', component: Noticias,canActivate: [authGuard] },
	{ path: 'register', component: Register },
    { path: 'fallas', component: Fallas },
    ];
