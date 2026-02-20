import { ChangeDetectorRef, Component, inject } from '@angular/core';
import { Header } from '../../components/header/header';
import { Request } from '../../services/request';


@Component({
  selector: 'app-fallas',
  imports: [Header],
  templateUrl: './fallas.html',
  styleUrl: './fallas.css',
})
export class Fallas {
  public active: string = 'fallas';
  public select: string = 'todos';


  public cdr = inject(ChangeDetectorRef)
  public data = inject(Request);
  public falla: any[] = [];

  public getResponse(): void {
    this.data.getMonuments().subscribe((response) => {
      this.falla = response;
      this.cdr.markForCheck()
    })
  }

  public ngOnInit() {
    this.getResponse();
  }
}
