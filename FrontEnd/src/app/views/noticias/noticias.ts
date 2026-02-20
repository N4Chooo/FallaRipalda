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

  public cdr = inject(ChangeDetectorRef);
  public data = inject(Request);
  public events: any[] = [];

  public getResponse(month: string): void {
    this.data.getEvents(month).subscribe((response) => {
      this.events = response;
      this.cdr.markForCheck();
    })
  }

  public ngOnInit(){
    this.getResponse(this.mes);
  }
  
  public onMonthChange(month: string) {
    this.mes = month;
    this.getResponse(month);
  }
}
