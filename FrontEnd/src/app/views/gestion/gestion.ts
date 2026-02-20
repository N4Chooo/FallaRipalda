import { ChangeDetectorRef, Component, inject } from '@angular/core';
import { Header } from '../../components/header/header';
import { Request } from '../../services/request';
import { FormsModule } from '@angular/forms';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-gestion',
  imports: [Header, FormsModule, ReactiveFormsModule],
  templateUrl: './gestion.html',
  styleUrl: './gestion.css',
})
export class Gestion {
  public active: string = 'gestion';
   public router = inject(Router);
  public cdr = inject(ChangeDetectorRef)
  public data = inject(Request);
  public falleros: any[] = [];
  public deletedFallero:{ [key: string]: string } = {};
  public faller: any = '';
  public creation: boolean = false;
  public show: boolean = false;
  public listB: boolean = true;
  private fallero: { [key: string]: string } = {};
  public edit:boolean = false;


  gestionForm = new FormGroup({
    name: new FormControl('', { nonNullable: true }),
    category: new FormControl('', { nonNullable: true }),
    reward: new FormControl('', { nonNullable: true }),
    payment: new FormControl('', { nonNullable: true }),
    rol: new FormControl('', { nonNullable: true }),
    fee: new FormControl('', { nonNullable: true }),
    dni: new FormControl('', { nonNullable: true }),
  })

  
  

  public getResponse(): void {
    this.data.getInfo().subscribe((response) => {
      this.falleros = response;
      this.cdr.markForCheck()
    })
  }

  public getDelete(id:any): void {
    this.data.deleteFallero(id).subscribe({
        next: (response) => {
          alert(response.status);
        },
        error: (err) => {
          const errorMessage = err.error?.status || 'Ocurrió un error inesperado';
          alert('Error: ' + errorMessage);
        }
      });
  }
 

  public create(): void {
    this.creation = true;
    this.listB = false;
    this.show = false;
    this.edit = false;
    
  }

  public delete(id:any): void {
    this.deletedFallero = { 'id': id };
    this.getDelete(this.deletedFallero);
    this.getResponse();
  }

  public list(): void {
    this.creation = false;
    this.show = false;
    this.listB = true;
    this.edit = false;
    this.getResponse();
  }

  public detail(falleroSelec:any): void { 
    this.faller = falleroSelec;
    this.creation = false;
    this.edit = false;
    this.show = true;
    this.listB = true;
    this.getResponse();
  }

  public editBtn(falleroSelec:any):void{
    this.creation = false;
    this.show = false;
    this.listB = true;
    this.edit = true;
    let pay = "";
    let fee = "";

    if(falleroSelec.payment_status == true){
      pay= "1";
    }else{
      pay="0";
    }
    if (falleroSelec.fee == 'Adulto General') {
    fee = "0";
  } else if (falleroSelec.fee == 'Infantil') {
    fee = "1";
  } else if (falleroSelec.fee == 'Juvenil') {
    fee = "2";
  } else if (falleroSelec.fee == 'Jubilado') {
    fee = "3";
  } else if (falleroSelec.fee == 'Honor') {
    fee = "4";
  } else if (falleroSelec.fee == 'Familiar 3+ miembros') {
    fee = "5";
  } else if (falleroSelec.fee == 'Bebé (0-2 años)') {
    fee = "6";
  } else if (falleroSelec.fee == 'Colaborador Externo') {
    fee = "7";
  } else if (falleroSelec.fee == 'Simpatizante') {
    fee = "8";
  } else if (falleroSelec.fee == 'Patrocinador VIP') {
    fee = "9";
  }

    this.editForm.patchValue({
    id: falleroSelec.id,
    name: falleroSelec.name,
    category: falleroSelec.category,
    reward: falleroSelec.rewards,
    payment: pay, 
    rol: falleroSelec.rol,
    fee: fee,
    dni: falleroSelec.dni
});
    this.cdr.markForCheck(); 
  
  }

  public ngOnInit() {
    this.getResponse();
  }

  public createFall(name: string, category: string, reward: string, payment: string, rol: string, fee: string, dni: string): void {
    this.fallero['name'] = name;
    this.fallero['category'] = category;
    this.fallero['reward'] = reward;
    this.fallero['payment'] = payment;
    this.fallero['rol'] = rol;
    this.fallero['fee'] = fee;
    this.fallero['dni'] = dni;

  }

   public createFallEdit(id:string ,name: string, category: string, reward: string, payment: string, rol: string, fee: string, dni: string): void {
    this.fallero['id'] = id;
    this.fallero['name'] = name;
    this.fallero['category'] = category;
    this.fallero['reward'] = reward;
    this.fallero['payment'] = payment;
    this.fallero['rol'] = rol;
    this.fallero['fee'] = fee;
    this.fallero['dni'] = dni;

  }


  public onSubmit(): void {
    let rawData = this.gestionForm.getRawValue();
    this.createFall(rawData.name, rawData.category, rawData.reward, rawData.payment, rawData.rol, rawData.fee, rawData.dni);
    if (rawData.dni.length == 9) {
      this.data.createFallero(this.fallero).subscribe({
        next: (response) => {
          alert(response.status);
          this.gestionForm.reset();
          this.list();
        },
        error: (err) => {
          const errorMessage = err.error?.status || 'Ocurrió un error inesperado';
          alert('Error: ' + errorMessage);
        }
      });
    } else {
      alert('Introduce un DNI correcto');
    }
  }

  public onEdit(){
    
    let rawData = this.editForm.getRawValue();
    this.createFallEdit(rawData.id ,rawData.name, rawData.category, rawData.reward, rawData.payment, rawData.rol, rawData.fee, rawData.dni);
    if (rawData.dni.length == 9) {
      this.data.updateFallero(this.fallero).subscribe({
        next: (response) => {
          alert(response.status);
          this.editForm.reset();
          this.list();
        },
        error: (err) => {
          const errorMessage = err.error?.status || 'Ocurrió un error inesperado';
          alert('Error: ' + errorMessage);
        }
      });
    } else {
      alert('Introduce un DNI correcto');
    }
  }

  editForm = new FormGroup({
    id : new FormControl('', { nonNullable: true }),
    name: new FormControl('', { nonNullable: true }),
    category: new FormControl('', { nonNullable: true }),
    reward: new FormControl('', { nonNullable: true }),
    payment: new FormControl('', { nonNullable: true }),
    rol: new FormControl('', { nonNullable: true }),
    fee: new FormControl('', { nonNullable: true }),
    dni: new FormControl('', { nonNullable: true }),
  })

}
