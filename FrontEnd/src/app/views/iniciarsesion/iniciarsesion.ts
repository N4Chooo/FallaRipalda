import { Component, inject } from '@angular/core';
import { Header } from '../../components/header/header';
import { RouterLink, RouterLinkActive, Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { Request } from '../../services/request';

@Component({
  selector: 'app-iniciarsesion',
  imports: [Header, RouterLink,FormsModule],
  templateUrl: './iniciarsesion.html',
  styleUrl: './iniciarsesion.css',
})
export class Iniciarsesion {
  public active: string = 'regins';
  public username = '';
  public password = '';
  public loginError = false;

  private authService = inject(Request);
  private router = inject(Router);

  onLogin() {
    this.loginError = false;

    this.authService.login(this.username, this.password).subscribe({
      next: (response) => {
        alert('Login exitoso');
        this.router.navigate(['/noticias']);
      },
      error: (err) => {
        alert('Error de autenticación, introduce credenciales validas');
        this.loginError = true;
      }
    });
  }

}
