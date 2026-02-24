import { Component, ChangeDetectorRef, inject } from '@angular/core';
import { Header } from '../../components/header/header';
import { Request } from '../../services/request';

@Component({
  selector: 'app-noticias',
  imports: [Header],
  templateUrl: './noticias.html',
  styleUrl: './noticias.css',
})
export class Noticias {
  public active: string = 'noticias';
  public mes: string = '';
  public usuario: any = '';
  public cdr = inject(ChangeDetectorRef);
  public data = inject(Request);
  public events: any[] = [];
  public selectEvents:any = '';
  public eventid:any = '';
  public user: any = '';
  public fallero: any = '';
  public ids: { [key: string]: number } = {};
  

  public getResponse(month: string): void {
    this.data.getEvents(month).subscribe((response) => {
      this.events = response;
      this.cdr.markForCheck();
    })
  }

  public getEvents(): void {
    this.data.getFalleroDni(localStorage.getItem('user_dni')).subscribe((response) => {
      this.selectEvents = response[0].event;
      this.eventid = response[0].eventId
      this.cdr.markForCheck();
      
    })
  }

  public ngOnInit() {
    this.getResponse(this.mes);
    this.getEvents();
  }

  public participate(event: any) {
    event.participated = true;
      this.data.getFalleroDni(localStorage.getItem('user_dni')).subscribe((response) => {
        this.fallero = response;
        this.cdr.markForCheck();
        this.ids = { 
            'PartId': this.fallero[0].id,
            'EvenId': event.id
        };
        this.data.addAssistant(this.ids).subscribe((response) => {
          alert(response.status)
        })
      })
  }

  public onMonthChange(month: string) {
    this.mes = month;
    this.getResponse(month);
  }

   public authService = inject(Request);
  onLogout() {
    this.authService.logout();
  }
}
