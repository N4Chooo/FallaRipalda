import { Injectable, inject, signal } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { catchError, map, of, tap, Observable } from 'rxjs';


@Injectable({
  providedIn: 'root',
})
export class Request {
  private http = inject(HttpClient);
  private router = inject(Router);
  private user = "https://fallaripalda-production.up.railway.app/api/register";
  private falleros = "https://fallaripalda-production.up.railway.app/api/participants";  //se puede filtrar por status(pagado o pendiente), rol,dni o category
  private fallas26 = "https://fallaripalda-production.up.railway.app/api/monuments?year=2026";
  private fallas = "https://fallaripalda-production.up.railway.app/api/monuments";//se puede filtrar por year
  private llibret = "https://fallaripalda-production.up.railway.app/api/books";  //se puede filtrar por year
  private events = "https://fallaripalda-production.up.railway.app/api/events";  //se puede filtrar por month
  private fees = "https://fallaripalda-production.up.railway.app/api/fees";
  private users = "https://fallaripalda-production.up.railway.app/api/user";
  private sponsors = "https://fallaripalda-production.up.railway.app/api/sponsors";
  private loginApi = "https://fallaripalda-production.up.railway.app/api/login";
  private participate = "https://fallaripalda-production.up.railway.app/api/participate";
  public userName = '';


  public createUser(userData: any): Observable<any> {
    return this.http.post<any>(this.user, userData);
  }

  public addAssistant(ids:any,){
    return this.http.post<any>(this.participate, ids);
  }

  public getInfo(): Observable<any> {
    return this.http.get<any>(this.falleros);
  }

  public getFalleroDni(dni:any): Observable<any> {
    return this.http.get<any>(`${this.falleros}?dni=${dni}`);
  }

  public createFallero(fallero:any): Observable<any> {
    return this.http.post<any>(this.falleros+'/create' , fallero);
  }

  public deleteFallero(id:any): Observable<any> {
    return this.http.post<any>(this.falleros+'/delete', id);
  }

   public updateFallero(fallero:any): Observable<any> {
    return this.http.put<any>(this.falleros+'/edit', fallero);
  }

  public getUsers(): Observable<any> {
    return this.http.get<any>(this.users);
  }

  private readonly AUTH_KEY = 'user_auth';

  public login(user: string, pass: string) {
    this.userName = user;
    const authString = btoa(`${user}:${pass}`);

    const headers = new HttpHeaders({
      Authorization: `Basic ${authString}`
    });

    return this.http.get<any>(`${this.loginApi}`, { headers }).pipe(
      tap((response) => {
        localStorage.setItem(this.AUTH_KEY, authString);
        if (response.roles) {
          localStorage.setItem('user_role' ,JSON.stringify(response.roles));
        }
        if (response.user) {
          localStorage.setItem('user_name', response.name);
        }
        if (response.dni) {
          localStorage.setItem('user_dni', response.dni);
        }
      })
    );
  }
  public getUsername() {
    return localStorage.getItem('user_name');
  }

  public isLoggedIn(): boolean {
    return !!localStorage.getItem(this.AUTH_KEY);
  }

  public hasRole(role: string): boolean {
    const rolesRaw = localStorage.getItem('user_role');;
    if (!rolesRaw) return false;

    const roles: string[] = JSON.parse(rolesRaw);
    return roles.includes(role);
  }

  public getAuthString(): string | null {
    return localStorage.getItem(this.AUTH_KEY);
  }

  public logout() {
    localStorage.removeItem(this.AUTH_KEY);
    localStorage.removeItem('user_role');
    localStorage.removeItem('user_name');
    localStorage.removeItem('user_dni');
    this.router.navigate(['/index']);
  }


  public getMonuments2026(): Observable<any> {
    return this.http.get<any>(this.fallas26)
  }

  public getMonuments(): Observable<any> {
    return this.http.get<any>(this.fallas)
  }

  public getEvents(month: string): Observable<any> {
    if (month == ''){
      return this.http.get<any>(this.events);
    }
    else{
      return this.http.get<any>(`${this.events}?month=${month}`);
    }
  }
}
