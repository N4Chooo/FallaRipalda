import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Fallas } from './fallas';

describe('Fallas', () => {
  let component: Fallas;
  let fixture: ComponentFixture<Fallas>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Fallas]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Fallas);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
