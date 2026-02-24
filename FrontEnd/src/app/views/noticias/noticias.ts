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
  public user: any = '';
  public fallero: any = '';
  public ids: { [key: string]: string } = {}

  public getResponse(month: string): void {
    this.data.getEvents(month).subscribe((response) => {
      this.events = response;
      this.cdr.markForCheck();
    })
  }

  public ngOnInit() {
    this.getResponse(this.mes);
  }

  public participate(id: any) {
    this.data.getUsers().subscribe((response) => {
      this.usuario = response.find((item: any) => item.name === localStorage.getItem('user_name'));
      this.cdr.markForCheck();
    })
    this.data.getFalleroDni(this.usuario.dni).subscribe((response) => {
      this.fallero = response;
      this.cdr.markForCheck();
       this.ids['PartId'] = this.fallero.id;
      this.ids['EvenId'] = id;
      this.data.addAssistant(this.ids).subscribe((response) => {
      })
    })

  }

  public onMonthChange(month: string) {
    this.mes = month;
    this.getResponse(month);
  }
}
