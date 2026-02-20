import { CanActivateFn, Router } from '@angular/router';
import { inject } from '@angular/core';
import { Request } from '../services/request';

export const adminGuard: CanActivateFn = (route, state) => {
  const authService = inject(Request);
  const router = inject(Router);

  if (authService.isLoggedIn() && authService.hasRole("ROLE_ADMIN")) {
    return true;
  }
 
  alert('Acceso denegado: Se requieren permisos de administrador');
  router.navigate(['/index']);
  return false;
};
