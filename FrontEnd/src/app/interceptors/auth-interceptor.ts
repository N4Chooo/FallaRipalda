import { HttpInterceptorFn } from '@angular/common/http';
import { inject } from '@angular/core';
import { Request } from '../services/request';

export const authInterceptor: HttpInterceptorFn = (req, next) => {
  const authService = inject(Request);
  const authData = authService.getAuthString();

  if (authData) {
    const authReq = req.clone({
      setHeaders: {
        Authorization: `Basic ${authData}`
      }
    });
    return next(authReq);
  }

  return next(req);
};
