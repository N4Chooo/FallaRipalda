import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { Request } from '../services/request';

export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(Request);
  const router = inject(Router);

  if (authService.isLoggedIn()) {
    return true; 
  } else {
    router.navigate(['/login']);
    return false;
  }
  
};
