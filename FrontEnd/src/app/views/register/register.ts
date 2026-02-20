import { Component, inject } from '@angular/core';
import { Header } from '../../components/header/header';
import { Router } from '@angular/router';
import { Request } from '../../services/request';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { RouterLink, RouterLinkActive } from '@angular/router';

@Component({
  selector: 'app-register',
  imports: [Header, ReactiveFormsModule, RouterLink, RouterLinkActive],
  templateUrl: './register.html',
  styleUrl: './register.css',
})
export class Register {
  public router = inject(Router);
  public active: string = 'regins';
  public data = inject(Request);
  private user: { [key: string]: string } = {};

  registerForm = new FormGroup({
    dni: new FormControl('', { nonNullable: true }),
    nombre: new FormControl('', { nonNullable: true }),
    mail: new FormControl('', { nonNullable: true }),
    contraseña: new FormControl('', { nonNullable: true }),
    terminos: new FormControl('', { nonNullable: true }),
  })

  public onSubmit(): void {
    let rawData = this.registerForm.getRawValue();
    if (rawData.terminos && rawData.dni && rawData.mail && rawData.contraseña && rawData.dni.length == 9 && rawData.contraseña.length >= 6) {
      this.validateDNI(rawData.dni, rawData.nombre, rawData.mail, rawData.contraseña);
    } else {
      alert('Rellena todos los campos correctamente')
    }
  }


  public create(dni: string, nombre: string, mail: string, contraseña: string): void {
    this.user['dni'] = dni;
    this.user['name'] = nombre;
    this.user['email'] = mail;
    this.user['plainPassword'] = contraseña;
  }

  public validateDNI(dni: string, nombre: string, mail: string, contraseña: string): void {
    let status = 0;
    this.data.getInfo().subscribe({
      next: (response) => {
        let falleros = response;
        this.data.getUsers().subscribe({
          next: (response) => {
            const usuariosDni = response.find((item: any) => item.dni === dni);

            if (usuariosDni) {
              alert('Usuario ya existente.');
              return;
            } else {
              const usuarioEncontrado = falleros.find((item: any) => item.dni === dni);

              if (!usuarioEncontrado) {
                alert('Contacta con secretaria para darte de alta como fallero.');
                return;
              }
              this.create(dni, nombre, mail, contraseña);
              this.data.createUser(this.user).subscribe({
                next: (response) => {
                  alert(response.status);
                  this.registerForm.reset();
                  this.router.navigate(['/login']);
                },
                error: (err) => {
                  const errorMessage = err.error?.status || 'Ocurrió un error inesperado';
                  alert('Error: ' + errorMessage);
                }
              });

            }
          },
          error: (err) => {
            const errorMessage = err.error?.status || 'Ocurrió un error inesperado';
            alert('Error: ' + errorMessage);
          }
        });
      },
      error: (err) => {
        const errorMessage = 'Contacta con secretaria para darte de alta como fallero';
        alert('Error: ' + errorMessage);
      }
    });

  }
}
