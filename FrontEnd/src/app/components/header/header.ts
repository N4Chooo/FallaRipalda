import { Component, Input, inject, Output, EventEmitter } from '@angular/core';
import { RouterLink, RouterLinkActive } from '@angular/router';
import { Request } from '../../services/request';

@Component({
  selector: 'app-header',
  imports: [RouterLink, RouterLinkActive],
  templateUrl: './header.html',
  styleUrl: './header.css',
})
export class Header {

  @Input() active: string = 'index';
  @Input() select: string = 'todos';
  @Input() month: string = '';
  public admin: boolean = false;

 
  @Output() selectChange = new EventEmitter<string>();

  public selectedYear(year: string): void {
    if(year == ''){
      this.selectChange.emit(this.select); 
    }else{
      this.select = year
      this.selectChange.emit(this.select); 
    }
  }

  public selectedMonth(month: string): void{
    if(month == ''){
      this.selectChange.emit(this.month);
    }else{
      this.select = month
      this.selectChange.emit(this.select);
    }
  }

  public authService = inject(Request);
  onLogout() {
    this.authService.logout();
  }
}
