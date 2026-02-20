import { ChangeDetectorRef, Component, inject } from '@angular/core';
import { Request } from '../../services/request';
import { RouterLink, RouterLinkActive } from '@angular/router';

@Component({
  selector: 'app-index',
  imports: [RouterLink],
  templateUrl: './index.html',
  styleUrl: './index.css',
})
export class Index {

  public cdr = inject(ChangeDetectorRef)
  public active: string = 'index';
  public data = inject(Request);
  public falla: any[] = [];
  public show: boolean = false;

  public getResponse(): void {
    this.data.getMonuments2026().subscribe((response) => {
      this.falla = response;
      console.log( this.falla);
      this.cdr.markForCheck()
    })
  }
  public authService = inject(Request);
  onLogout() {
    this.authService.logout();
  }

  public ngOnInit() {
    this.getResponse();
    this.show = true;
  }

}
