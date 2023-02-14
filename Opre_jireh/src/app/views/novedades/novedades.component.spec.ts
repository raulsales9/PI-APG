import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NovedadesComponent } from './novedades.component';

describe('NovedadesComponent', () => {
  let component: NovedadesComponent;
  let fixture: ComponentFixture<NovedadesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ NovedadesComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(NovedadesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
